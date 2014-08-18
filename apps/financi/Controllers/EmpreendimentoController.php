<?php

namespace Controllers;

use Opis\Session\Session;
use Financi\DataFormat;

class EmpreendimentoController extends \SlimController\SlimController
{
    public function indexAction()
    {
        $this->render('empreendimento/index.php', [
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'bower_components/slimScroll/jquery.slimscroll.min.js', 'js/cadastros/empreendimento.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $conditions = ['empreendimento.status <> ?', 0];

        if($get['query']) {
            $query = new \Empreendimento();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['empreendimento.id in(?) AND empreendimento.status <> ?', $pks, 0];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1] )); 
            }
        }

        $empreendimentos_total = \Empreendimento::find('all', [
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = 10;

        $total = count($empreendimentos_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        $empreendimentos = \Empreendimento::find('all', [
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio
            ]);

        $arr = [];

        foreach ($empreendimentos as $e) {
            $e_arr = $e->to_array();
            $e_arr['comissao'] = DataFormat::showMoney($e_arr['comissao']);
            $e_arr['intermediarias'] = DataFormat::showMoney($e_arr['intermediarias']);
            $e_arr['taxa_financiamento'] = DataFormat::showMoney($e_arr['taxa_financiamento']);
            
            foreach ($e->corretores as $c) {
                $e_arr['corretores'][] = ['id' => $c->corretor_id, 'nome' => $c->corretor->nome];
            }

            $arr[] = $e_arr;
        }

        return $this->app->response->setBody(json_encode( ['empreendimentos' => $arr, 'paginas' => $total_paginas] ));
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

        if($acao == 'excluir') {
            foreach ($data as $d) {
                $empreendimento = \Empreendimento::find($d->id);
                $empreendimento->status = 0;
                if(count($empreendimento)) {
                    $empreendimento->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 2] )); 
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
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }
    }
}