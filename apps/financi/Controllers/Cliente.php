<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class Cliente extends \SlimController\SlimController 
{
	public function indexAction()
	{
        $clientes = \Clientes::find('all');

        foreach ($clientes as $c) {
            $find = \Clientes::find($c->id);
            $find->status = 1;
            $find->save();
        }

		$this->render('cliente/index.php', [
                'clientes' => $clientes,
                'foot_js' => [ 'js/cadastros/cliente_index.js' ]
            ]);
	}

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $conditions = ['cliente.status = ? OR cliente.status = ?', 1, 2];

        if($get['query']) {
            $query = new \Clientes();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['cliente.id in(?) AND cliente.status = ? OR cliente.status = ?', $pks, 1, 2];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1] )); 
            }
        }

        $clientes_total = \Clientes::find('all', [
                'select' => 'cliente.id',
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = 5;

        $total = count($clientes_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        $clientes = \Clientes::find('all', [
                'select' => 'cliente.id, cliente.nome, cliente.cpf, cliente.status',
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio
            ]);

        $arr = [];

        foreach ($clientes as $c) {
            $arr[] = $c->to_array();
        }

        return $this->app->response->setBody(json_encode( [ 'search'=>true, 'clientes' => $arr, 'paginas' => $total_paginas] ));
    }

    public function cadastroPfAction()
    {

        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('cliente/pf.php', [
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/clientes.js' ]
            ]);
    }

    public function editaPfAction($id)
    {
        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('cliente/pf.php', [
                'id' => $id,
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/cliente.edita.pf.js' ]
            ]);
    }

    public function cadastroPjAction()
    {
        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('cliente/pj.php', [
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/clientes.js' ]
            ]);
    }

    public function cidadesAction($uf)
    {
        $this->app->contentType('application/json');

        $cidades = WebServices::service('cidades_por_uf/' . $uf);

        return $this->app->response->setBody(json_encode( $cidades )); 
    }

    public function buscaAction($id)
    {
        $this->app->contentType('application/json');

        $cliente = \Clientes::find($id);

        $enderecos = \ClienteEndereco::find('all', [
                'conditions' => ['cliente_id = ?', $cliente->id]
            ]);

        $conjuge = \ClienteConjuge::find('one', [
                'conditions' => ['cliente_id = ?', $cliente->id]
            ]);

        $principal = isset($enderecos[0]) ? $enderecos[0]->to_array() : [];
        $secundario = isset($enderecos[1]) ? $enderecos[1]->to_array() : false;

        $cliente_array = $cliente->to_array();
        $cliente_array['data_nascimento'] = isset($cliente_array['data_nascimento']) ? $cliente->data_nascimento->format('d/m/Y') : false;

        if(!$cliente_array['data_nascimento']) {
            unset($cliente_array['data_nascimento']);
        }

        if(count($conjuge)) {
            $cliente_array = array_merge($cliente_array, ['conjuge' => $conjuge->to_array()]);
        }

        if($secundario) {
            $array = array_merge($cliente_array, ['endereco' => [$principal, $secundario]]);
        } else {
            $array = array_merge($cliente_array, ['endereco' => [$principal]]);
        }

        return $this->app->response->setBody(json_encode( ['cliente' => $array ] )); 
    }


    public function salvarPfAction()
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody('cliente'));

        if(!isset($data->id)) {
        
            $data->instituicao_id = 1;

            $endereco = isset($data->endereco) ? $data->endereco : false;
            $conjuge = isset($data->conjuge) ? $data->conjuge : false;

            unset($data->endereco);
            unset($data->conjuge);

            $cliente = new \Clientes($data);
            
            if($cliente->save())
            {

                if($endereco) {
                    foreach ($endereco as $e) {
                        $e->cliente_id = $cliente->id;
                        
                        $cliente_endereco = new \ClienteEndereco($e);
                        $cliente_endereco->save();
                    }
                }

                if($conjuge) {
                    $conjuge->cliente_id = $cliente->id;
                    //$conjuge->data_cadastro = date('Y-m-d H:i:S');
                    unset($conjuge->residencia);
                    $cliente_conjuge = new \ClienteConjuge($conjuge);
                    $cliente_conjuge->save();
                }

                return $this->app->response->setBody(json_encode( ['success' => true] )); 
            }

        } else {

            $endereco = isset($data->endereco) ? $data->endereco : false;
            $conjuge = isset($data->conjuge) ? $data->conjuge : false;

            unset($data->endereco);
            unset($data->conjuge);

            $cliente = \Clientes::find($data->id);

            if($cliente->update_attributes($data)) {

                if($endereco) {
                    foreach ($endereco as $e) {
                        if(isset($e->id)) {
                            $cliente_endereco = \ClienteEndereco::find($e->id);
                            if(count($cliente_endereco)) {
                                $cliente_endereco->update_attributes($e);
                            }
                        } else {
                            $e->cliente_id = $data->id;
                            $cliente_endereco = new \ClienteEndereco($e);
                            $cliente_endereco->save();
                        }
                    }
                }

                if($conjuge) {
                    if($conjuge->id) {
                        $cliente_conjuge = \Clientes::find($conjuge->id);
                        $cliente_conjuge->update_attributes($conjuge);
                    } else {
                        $conjuge->cliente_id = $cliente->id;
                        $cliente_conjuge = new \ClienteConjuge($conjuge);
                        $cliente_conjuge->save();
                    }
                }

                return $this->app->response->setBody(json_encode( ['success' => true] ));

            }


        }
        
    }
}
