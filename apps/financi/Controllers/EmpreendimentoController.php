<?php

namespace Controllers;

use Opis\Session\Session;
use Financi\DataFormat;

class EmpreendimentoController extends \SlimController\SlimController
{
    public function indexAction()
    {
        $this->render('empreendimento/index.php', [
                'breadcrumb' => ['Cadastro', 'Empreendimentos'],
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'bower_components/slimScroll/jquery.slimscroll.min.js', 'js/cadastros/empreendimento.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }

    public function oneAction($id) 
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();
        
        if($id) {
            $empreendimento = \Empreendimento::find($id);
            
            if(count($empreendimento)) {
                $e_arr = $empreendimento->to_array();
                $e_arr['comissao'] = DataFormat::showMoney($e_arr['comissao']);
                $e_arr['entrada'] = DataFormat::showMoney($e_arr['entrada']);
                $e_arr['intermediarias'] = DataFormat::showMoney($e_arr['intermediarias']);
                $e_arr['taxa_financiamento'] = DataFormat::showMoney($e_arr['taxa_financiamento']);
                
                foreach ($empreendimento->corretores as $c) {
                    $e_arr['corretores'][] = ['id' => $c->corretor_id, 'nome' => $c->corretor->nome];
                }

                return $this->app->response->setBody(json_encode( ['success' => true,'empreendimento' => $e_arr] ));
            }
        }
    }

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $total_geral = \Empreendimento::find('one', [
                'select' => 'count(*) as total',
                'conditions' => ['empreendimento.status <> ?', 0]
            ]);

        $conditions = ['empreendimento.status <> ?', 0];

        if($get['query']) {
            $query = new \Empreendimento();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['empreendimento.id in(?) AND empreendimento.status <> ?', $pks, 0];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1, 'busca' => true, 'total_geral' => $total_geral->total ] )); 
            }
            $busca = true;
        } else {
            $busca = false;
        }

        $empreendimentos_total = \Empreendimento::find('all', [
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = PAGE_LIMIT;

        $total = count($empreendimentos_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        if(isset($get['column']) && isset($get['sort'])) {
            $sort = $get['column'] . ' ' . $get['sort'];
        } else {
            $sort = '';
        }

        $empreendimentos = \Empreendimento::find('all', [
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio,
                'order' => $sort
            ]);

        $arr = [];

        foreach ($empreendimentos as $e) {
            $e_arr = $e->to_array();
            $e_arr['comissao'] = DataFormat::showMoney($e_arr['comissao']);
            $e_arr['entrada'] = DataFormat::showMoney($e_arr['entrada']);
            $e_arr['intermediarias'] = DataFormat::showMoney($e_arr['intermediarias']);
            $e_arr['taxa_financiamento'] = DataFormat::showMoney($e_arr['taxa_financiamento']);
            
            foreach ($e->corretores as $c) {
                $e_arr['corretores'][] = ['id' => $c->corretor_id, 'nome' => $c->corretor->nome];
            }

            $arr[] = $e_arr;
        }

        return $this->app->response->setBody(json_encode( ['empreendimentos' => $arr, 'paginas' => $total_paginas, 'busca' => $busca, 'total_geral' => $total_geral->total] ));
    }

    public function novoAction()
    {   

        $this->app->contentType('application/json');

        $data = json_decode($this->app->request->getBody());

        $corretores = isset($data->corretores) ? $data->corretores : [];
        unset($data->corretores);

        $acao = '';

        if($data->id) {
            $empreendimento = \Empreendimento::find($data->id);
            $empreendimento->update_attributes($data);
            $empreendimento->save();
            $acao = '5';
        } else {

            $data->instituicao_id = \Financi\Auth::getUser()['instituicao_id'];
            $empreendimento = new \Empreendimento($data);
            $empreendimento->save();
            $acao = '1';
        }


        $empreendimento_corretor = \EmpreendimentoCorretor::query("DELETE FROM empreendimento_corretor WHERE empreendimento_corretor.empreendimento_id = ?", [$empreendimento->id]);
        

        foreach ($corretores as $c) {
            $c->empreendimento_id = $empreendimento->id;
            $c->corretor_id = $c->id;
            unset($c->nome);
            unset($c->id);
            $novo_empreendimento_corretor = new \EmpreendimentoCorretor($c);
            $novo_empreendimento_corretor->save();
        }

        return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => $acao] ));
    }

    public function acoesAction($acao) 
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        $conn = \Empreendimento::connection();

        if($acao == 'excluir') {
            try {
                $conn->transaction();

                foreach ($data as $d) {
                    $empreendimento = \Empreendimento::find($d->id);
                    
                    $teste = \Empreendimento::in_used($empreendimento, $d->id);

                    if($teste) {
                        throw new \Exception("Error Processing Request", 1);
                    }

                    $empreendimento->status = 0;
                    if(count($empreendimento)) {
                        $empreendimento->save();
                    }
                }

                $conn->commit();

                return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 2] ));
            } catch(\Exception $e) {
                $conn->rollback();

                return $this->app->response->setBody(json_encode( ['success' => false, 'msg' => 35, 'error' => $e->getMessage()] ));
            }
        }

        if($acao == 'desabilitar') {
            foreach ($data as $d) {
                $empreendimento = \Empreendimento::find($d->id);
                $empreendimento->status = 2;
                if(count($empreendimento)) {
                    $empreendimento->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }

        if($acao == 'habilitar') {
            foreach ($data as $d) {
                $empreendimento = \Empreendimento::find($d->id);
                $empreendimento->status = 1;
                if(count($empreendimento)) {
                    $empreendimento->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 3] )); 
        }
    }
}