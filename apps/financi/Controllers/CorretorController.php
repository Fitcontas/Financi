<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class CorretorController extends \SlimController\SlimController 
{
    public function indexAction()
    {
        $corretores = \Corretor::find('all');

        $this->render('corretor/index.php', [
                'breadcrumb' => ['Cadastro', 'Corretores'],
                'corretores' => $corretores,
                'foot_js' => [ 'js/cadastros/corretor_index.js', 'bower_components/lodash/dist/lodash.min.js' ]
            ]);
    }

    public function novoAction()
    {

        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('corretor/novo.php', [
                'breadcrumb' => ['Cadastro', 'Corretores', 'Novo'],
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/corretor_novo.js' ]
            ]);
    }

    public function acoesAction($acao) 
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        if($acao == 'excluir') {
            foreach ($data as $d) {
                $corretor = \Corretor::find($d->id);
                $corretor->status = 0;
                if(count($corretor)) {
                    $corretor->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 2] )); 
        }

        if($acao == 'desabilitar') {
            foreach ($data as $d) {
                $corretor = \Corretor::find($d->id);
                $corretor->status = 2;
                if(count($corretor)) {
                    $corretor->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }

        if($acao == 'habilitar') {
            foreach ($data as $d) {
                $corretor = \Corretor::find($d->id);
                $corretor->status = 1;
                if(count($corretor)) {
                    $corretor->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }
    }

    public function editaAction($id)
    {
        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('corretor/novo.php', [
                'breadcrumb' => ['Cadastro', 'Corretores', 'Edição'],
                'id' => isset($id) ? $id : '',
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/corretor.edita.js' ]
            ]);
    }

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $conditions = ['corretor.status = ? OR corretor.status = ?', 1, 2];

        if($get['query']) {
            $query = new \Corretor();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['corretor.id in(?) AND corretor.status = ? OR corretor.status = ?', $pks, 1, 2];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1] )); 
            }
        }

        $corretores_total = \Corretor::find('all', [
                'select' => 'corretor.id',
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = PAGE_LIMIT;

        $total = count($corretores_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        if(isset($get['column']) && isset($get['sort'])) {
            $sort = $get['column'] . ' ' . $get['sort'];
        } else {
            $sort = '';
        }

        $corretores = \Corretor::find('all', [
                'select' => 'corretor.id, corretor.nome, corretor.cpf, corretor.status',
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio,
                'order' => $sort
            ]);

        $arr = [];

        foreach ($corretores as $c) {

            $ar = $c->to_array();

            $telefones = [];
            foreach ($c->telefones as $t) {
                $telefones[] = $t->to_array();
            }

            $emails = [];
            foreach ($c->emails as $e) {
                $emails[] = $e->to_array();
            }

            $array_contatos = ['emails'=>$emails, 'telefones' => $telefones];

            if($ar['cnpj']) {
                $ar['cnpj'] = \Financi\DataFormat::mask($ar['cnpj'], '##.###.###/###-##');
            } else {
                $ar['cpf'] = \Financi\DataFormat::mask($ar['cpf'], '###.###.###-##');
            }

            $final_array = array_merge($ar, $array_contatos);

            $arr[] = $final_array;
        }

        return $this->app->response->setBody(json_encode( [ 'search'=>true, 'corretores' => $arr, 'paginas' => $total_paginas] ));
    }

    public function corretoresAction()
    {
        $this->app->contentType('application/json');

        $corretores = \Corretor::find('all', [
                'select' => 'corretor.id, corretor.nome',
                'conditions' => ['status = 1']
            ]);

        $array = [];

        if (count($corretores)) {
            foreach ($corretores as $c) {
                $array[] = $c->to_array();
            }
        }

        $this->app->response->setBody(json_encode( ['corretores' => $array] )); 
    }

    public function buscaAction($id)
    {
        $this->app->contentType('application/json');

        $corretor = \Corretor::find($id);

        $enderecos = \CorretorEndereco::find('all', [
                'conditions' => ['corretor_id = ?', $corretor->id]
            ]);

        $principal = isset($enderecos[0]) ? $enderecos[0]->to_array() : [];
        $secundario = isset($enderecos[1]) ? $enderecos[1]->to_array() : false;

        $corretor_array = $corretor->to_array();

        $corretor_array['data_nascimento'] = isset($corretor_array['data_nascimento']) ? $corretor->data_nascimento->format('d/m/Y') : '';

        $corretor_array['expedicao'] = isset($corretor_array['expedicao']) ? $corretor->expedicao->format('d/m/Y') : '';

        $corretor_array['data_cadastro'] = isset($corretor_array['data_cadastro']) ? $corretor->data_cadastro->format('d/m/Y') : '';

        if(!$corretor_array['data_nascimento']) {
            unset($corretor_array['data_nascimento']);
        }

        if(!$corretor_array['expedicao']) {
            unset($corretor_array['expedicao']);
        }

        if($secundario) {
            $array = array_merge($corretor_array, ['endereco' => [$principal, $secundario]]);
        } else {
            $array = array_merge($corretor_array, ['endereco' => [$principal]]);
        }

        $telefones = [];
        foreach ($corretor->telefones as $t) {
            $telefones[] = $t->to_array();
        }

        $emails = [];
        foreach ($corretor->emails as $e) {
            $emails[] = $e->to_array();
        }

        $array = array_merge($array, ['telefones' => $telefones], ['emails' => $emails]);

        return $this->app->response->setBody(json_encode( ['corretor' => $array ] )); 
    }

    public function salvarAction()
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody('corretor'));

        if(!isset($data->id)) {
        
            $data->instituicao_id = \Financi\Auth::getUser()['instituicao_id'];
            $data->data_cadastro = date('Y-m-d H:i:s');
            $data->data_nascimento = \Financi\DataFormat::DatetimeBd($data->data_nascimento);

            $endereco = isset($data->endereco) ? $data->endereco : false;
            $telefones = isset($data->telefones) ? $data->telefones : [];
            $emails = isset($data->emails) ? $data->emails : [];

            unset($data->endereco);
            unset($data->telefones);
            unset($data->emails);

            $corretor = new \Corretor($data);
            
            if($corretor->save())
            {

                if($endereco) {
                    foreach ($endereco as $e) {
                        $e->corretor_id = $corretor->id;
                        
                        $corretor_endereco = new \CorretorEndereco($e);
                        $corretor_endereco->save();
                    }
                }

                if($conjuge) {
                    $conjuge->corretor_id = $corretor->id;
                    //$conjuge->data_cadastro = date('Y-m-d H:i:S');
                    unset($conjuge->residencia);
                    $corretor_conjuge = new \CorretorConjuge($conjuge);
                    $corretor_conjuge->save();
                }

                foreach ($telefones as $t) {
                    if(isset($t->ddd) && isset($t->tipo) && isset($t->numero)) {
                        $t->corretor_id = $corretor->id;
                        $telefone = new \CorretorTelefone($t);
                        $telefone->save();
                    }
                }

                foreach ($emails as $e) {
                    if(isset($e->tipo) && isset($e->email)) {
                        $e->corretor_id = $corretor->id;
                        $email = new \CorretorEmail($e);
                        $email->save();
                    }
                }

                return $this->app->response->setBody(json_encode( ['success' => true] )); 
            }

        } else {

            $endereco = isset($data->endereco) ? $data->endereco : false;
            $conjuge = isset($data->conjuge) ? $data->conjuge : false;
            $telefones = isset($data->telefones) ? $data->telefones : [];
            $emails = isset($data->emails) ? $data->emails : [];

            $data->data_nascimento = \Financi\DataFormat::DatetimeBd($data->data_nascimento);

            unset($data->endereco);
            unset($data->conjuge);
            unset($data->telefones);
            unset($data->emails);

            $corretor = \Corretor::find($data->id);

            if($corretor->update_attributes($data)) {

                if($endereco) {
                    foreach ($endereco as $e) {
                        if(isset($e->id)) {
                            $corretor_endereco = \CorretorEndereco::find($e->id);
                            if(count($corretor_endereco)) {
                                $corretor_endereco->update_attributes($e);
                            }
                        } else {
                            $e->corretor_id = $corretor->id;
                            print_r($e);
                            $corretor_endereco = new \CorretorEndereco($e);
                            $corretor_endereco->save();
                        }
                    }
                }


                $remove_telefones = \CorretorTelefone::query("DELETE FROM corretor_telefone WHERE corretor_id = ?", [$corretor->id]);

                foreach ($telefones as $t) {
                    if(isset($t->ddd) && isset($t->tipo) && isset($t->numero)) {
                        $t->corretor_id = $corretor->id;
                        $telefone = new \CorretorTelefone($t);
                        $telefone->save();
                    }
                }

                $remove_emails = \CorretorEmail::query("DELETE FROM corretor_email WHERE corretor_id = ?", [$corretor->id]);

                foreach ($emails as $e) {
                    if(isset($e->tipo) && isset($e->email)) {
                        $e->corretor_id = $corretor->id;
                        $email = new \CorretorEmail($e);
                        $email->save();
                    }
                }

                return $this->app->response->setBody(json_encode( ['success' => true] ));

            }


        }

    }

    public function queryAction($query)
    {
        $this->app->contentType('application/json');
        $corretores = \Corretor::find('all', [
                'conditions' => ['corretor.status = 1 AND corretor.nome like ?', '%'.$query.'%']
            ]);

        $arr = [];
        foreach ($corretores as $corretor) {
            $arr[] = $corretor->to_array();
        }

        return $this->app->response->setBody(json_encode( $arr ));
    }
        
}