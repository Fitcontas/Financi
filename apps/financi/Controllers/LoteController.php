<?php

namespace Controllers;

use Opis\Session\Session;
use Financi\DataFormat;

class LoteController extends \SlimController\SlimController
{
    public function indexAction()
    {

        $empreendimentos = \Empreendimento::find('all', [
                'conditions' => [ 'instituicao_id = ? and status = 1', \Financi\Auth::getUser()['instituicao_id']]
            ]);

        $this->render('lote/index.php', [
                'breadcrumb' => ['Cadastro', 'Lotes'],
                'empreendimentos' => $empreendimentos,
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'bower_components/slimScroll/jquery.slimscroll.min.js', 'js/cadastros/lote.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }

    public function lotesCorretorAction()
    {

        $empreendimentos = \Empreendimento::find('all', [
                'conditions' => [ 'instituicao_id = ? and status = 1', \Financi\Auth::getUser()['instituicao_id']]
            ]);

        $this->render('lote/corretor.php', [
                'breadcrumb' => ['Relação de Lotes'],
                'empreendimentos' => $empreendimentos,
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'bower_components/slimScroll/jquery.slimscroll.min.js', 'js/cadastros/lote.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $conditions = ['lote.status <> ?', 0];

        if($get['query']) {
            $query = new \Lote();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['lote.id in(?) AND lote.status <> ?', $pks, 0];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1, 'busca' =>true] )); 
            }
            $busca = true;
        } else {
            $busca = false;
        }

        $lotes_total = \Lote::find('all', [
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = PAGE_LIMIT;

        $total = count($lotes_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        if(isset($get['column']) && isset($get['sort'])) {
            $sort = $get['column'] . ' ' . $get['sort'];
        } else {
            $sort = '';
        }

        $lotes = \Lote::find('all', [
                'select' => 'lote.*, empreendimento.empreendimento',
                'joins' => ['empreendimento'],
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio,
                'order' => $sort
            ]);

        $arr = [];

        foreach ($lotes as $e) {
            $final_arr = $e->to_array();
            $final_arr['valor'] = number_format($final_arr['valor'], 2, ',', '.');
            $final_arr['frente_metro'] = number_format($final_arr['frente_metro'], 2, ',', '.');
            $final_arr['fundo_metro'] = number_format($final_arr['fundo_metro'], 2, ',', '.');
            $final_arr['lateral_direita_metro'] = number_format($final_arr['lateral_direita_metro'], 2, ',', '.');
            $final_arr['lateral_esquerda_metro'] = number_format($final_arr['lateral_esquerda_metro'], 2, ',', '.');
            $final_arr['area_total'] = number_format($final_arr['area_total'], 2, ',', '.');
            $arr[] = $final_arr;
        }

        return $this->app->response->setBody(json_encode( ['lotes' => $arr, 'paginas' => $total_paginas, 'busca' => $busca] ));
    }

    public function novoAction()
    {   

        $this->app->contentType('application/json');

        $data = json_decode($this->app->request->getBody());


        $data->valor = \Financi\DataFormat::money($data->valor);

        if(!isset($data->id)) {
            $lote = new \Lote($data);
            $lote->save();
            $acao = 1;
        } else {
            unset($data->empreendimento);
            $lote = \Lote::find($data->id);
            $lote->update_attributes($data);
            $acao = 5;
        }


        return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => $acao] ));
    }

    public function acoesAction($acao) 
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        $conn = \Lote::connection();

        if($acao == 'excluir') {
            try {
                $conn->transaction();

                foreach ($data as $d) {
                    $lote = \Lote::find($d->id);

                    if($lote->situacao != null) {
                        throw new \Exception("Situação diferente de null " . $lote->situacao, 1);
                    }
                    
                    $teste = \Lote::in_used($lote, $d->id);
                    if($teste) {
                        throw new \Exception("Registro em uso", 1);
                    }

                    $lote->status = 0;
                    if(count($lote)) {
                        $lote->save();
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
                $lote = \Lote::find($d->id);
                $lote->status = 2;
                if(count($lote)) {
                    $lote->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }

        if($acao == 'habilitar') {
            foreach ($data as $d) {
                $lote = \Lote::find($d->id);
                $lote->status = 1;
                if(count($lote)) {
                    $lote->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }
    }

    public function lotesAction($empreendimento_id)
    {

        $empreendimento = \Empreendimento::find($empreendimento_id);

        $corretores = [];
        foreach ($empreendimento->corretores as $c) {
            $corretores[] = ['id'=> $c->corretor_id, 'nome' => $c->corretor->nome];
        }

        $lotes = \Lote::find('all', [
                'conditions' => [ 'empreendimento_id = ? and situacao IS NULL', $empreendimento_id ]
            ]);

        $array = [];

        foreach ($lotes as $l) {
            $array[] = $l->to_array();
        }

        return $this->app->response->setBody(json_encode( [ 'lotes' => $array, 'empreendimento' => $empreendimento->to_array(), 'corretores' => $corretores ] ));
    }
}