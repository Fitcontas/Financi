<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class ClienteController extends \SlimController\SlimController 
{
	public function indexAction()
	{
		$this->render('cliente/index.php', [
                'breadcrumb' => ['Cadastro', 'Clientes'],
                'foot_js' => [ 'js/cadastros/cliente_index.js', 'bower_components/lodash/dist/lodash.min.js' ]
            ]);
	}
    
    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $total_geral = \Clientes::find('one', [
                'select' => 'count(*) as total',
                'conditions' => ['cliente.status <> ?', 0]
            ]);

        $conditions = ['cliente.status = ? OR cliente.status = ?', 1, 2];

        if($get['query']) {
            $query = new \Clientes();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['cliente.id in(?) AND cliente.status = ? OR cliente.status = ?', $pks, 1, 2];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1, 'busca' =>true, 'total_geral' => $total_geral->total] )); 
            }
            $busca = true;
        } else {
            $busca = false;
        }

        $clientes_total = \Clientes::find('all', [
                'select' => 'cliente.id',
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = PAGE_LIMIT;

        $total = count($clientes_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        if(isset($get['column']) && isset($get['sort'])) {
            $sort = $get['column'] . ' ' . $get['sort'];
        } else {
            $sort = 'nome asc';
        }

        $clientes = \Clientes::find('all', [
                'select' => 'cliente.id, cliente.nome, cliente.cpf, cliente.cnpj, cliente.status',
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio,
                'order' => $sort
            ]);

        $arr = [];

        foreach ($clientes as $c) {
            $ar = $c->to_array();

            $telefones = [];
            
            foreach ($c->telefones as $t) {
                $telefones[] = $t->to_array();
            }

             $array_contatos = ['telefones' => $telefones];

            $final_array = array_merge($ar, $array_contatos);
            
            $arr[] = $final_array;
        }

        return $this->app->response->setBody(json_encode( [ 'search'=>true, 'clientes' => $arr, 'paginas' => $total_paginas, 'busca' => $busca, 'total_geral' => $total_geral->total] ));
    }

    public function getClientesAction() {
        $this->app->contentType('application/json');
        $clientes = \Clientes::find('all', [
                'select' => 'cliente.id, cliente.nome',
                'conditions' => [ 'status = 1' ],
            ]);

        $arr = [];
        if(count($clientes)) {
            foreach ($clientes as $c) {
                $arr[] = $c->to_array();
            }
        }
        return $this->app->response->setBody(json_encode( [ 'success' => true, 'clientes' => $arr ] ));
    }

    public function cadastroPfAction()
    {
        $get = $this->app->request->get();

        $origem = isset($get['origem']) ? 1 : 0;

        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('cliente/pf.php', [
                'breadcrumb' => ['Cadastro', 'Clientes', 'Pessoa Física'],
                'origem' => $origem,
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/clientes.js' ]
            ]);
    }

    public function editaPfAction($id)
    {
        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $cliente = \Clientes::find($id);

        $this->render('cliente/pf.php', [
                'breadcrumb' => ['Cadastro', 'Clientes', 'Editando ' . strtoupper($cliente->nome) ],
                'id' => $id,
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/cliente.edita.pf.js' ]
            ]);
    }

    public function editaPjAction($id)
    {
        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $cliente = \Clientes::find($id);

        $this->render('cliente/pj.php', [
                'breadcrumb' => ['Cadastro', 'Clientes', 'Editando ' . strtoupper($cliente->nome) ],
                'id' => $id,
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'js/cadastros/cliente.edita.pf.js' ]
            ]);
    }

    public function cadastroPjAction()
    {
        $get = $this->app->request->get();

        $origem = isset($get['origem']) ? 1 : 0;

        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('cliente/pj.php', [
                'breadcrumb' => ['Cadastro', 'Clientes', 'Pessoa Jurídica'],
                'ufs' => is_array($ufs) ? $ufs : [],
                'origem' => $origem,
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'js/cadastros/clientes.js' ]
            ]);
    }

    public function cidadesAction($uf)
    {
        $this->app->contentType('application/json');

        $cidades = WebServices::service('cidades_por_uf/' . $uf);

        return $this->app->response->setBody(json_encode( $cidades )); 
    }

    public function estadosAction()
    {
        $this->app->contentType('application/json');

        $estados = WebServices::service('estados');

        return $this->app->response->setBody(json_encode( $estados )); 
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
        $cliente_array['data_nascimento'] = isset($cliente_array['data_nascimento']) ? $cliente->data_nascimento->format('d/m/Y') : '';

        $cliente_array['expedicao'] = isset($cliente_array['expedicao']) ? $cliente->expedicao->format('d/m/Y') : '';

        if(!$cliente_array['data_nascimento']) {
            unset($cliente_array['data_nascimento']);
        }

        if(!$cliente_array['expedicao']) {
            unset($cliente_array['expedicao']);
        }

        $cliente_array['capital_social'] = \Financi\DataFormat::showMoney($cliente->capital_social);

        if(count($conjuge)) {
            $arr_conjuge = $conjuge->to_array();
            
            $arr_conjuge['data_nascimento'] = isset($arr_conjuge['data_nascimento']) ? $conjuge->data_nascimento->format('d/m/Y') : '';
            
            $arr_conjuge['expedicao'] = isset($arr_conjuge['expedicao']) ? $conjuge->expedicao->format('d/m/Y') : '';

            $cliente_array = array_merge($cliente_array, ['conjuge' => $arr_conjuge]);
        }

        if($secundario) {
            $array = array_merge($cliente_array, ['endereco' => [$principal, $secundario]]);
        } else {
            $array = array_merge($cliente_array, ['endereco' => [$principal]]);
        }

        $telefones = [];
        foreach ($cliente->telefones as $t) {
            $telefones[] = $t->to_array();
        }

        $emails = [];
        foreach ($cliente->emails as $e) {
            $emails[] = $e->to_array();
        }

        if($cliente->cnae){
            $cnae = \Cnae::find($cliente->cnae);
        }

        $array = array_merge($array, ['telefones' => $telefones], ['emails' => $emails]);

        if($cliente->naturalidade) {
            $cidade_naturalidade = WebServices::service('cidade/'.$cliente->naturalidade);
        } else {
            $cidade_naturalidade = '';
        }

        return $this->app->response->setBody(json_encode( ['cliente' => $array, 'cnae' => ['id' => $cnae->id, 'text' => utf8_encode($cnae->descricao) ], 'cidade_naturalidade' => [ $cidade_naturalidade->rows ] ] )); 
    }


    public function salvarPfAction()
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody('cliente'));

        if(!isset($data->id)) {
        
            $data->instituicao_id = \Financi\Auth::getUser()['instituicao_id'];

            $endereco = isset($data->endereco) ? $data->endereco : false;
            $conjuge = isset($data->conjuge) ? $data->conjuge : false;
            $telefones = isset($data->telefones) ? $data->telefones : [];
            $emails = isset($data->emails) ? $data->emails : [];

            unset($data->endereco);
            unset($data->conjuge);
            unset($data->telefones);
            unset($data->emails);

            $data->expedicao = \Financi\DataFormat::DateDB($data->expedicao);
            $data->data_nascimento = \Financi\DataFormat::DateDB($data->data_nascimento);

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
                    $conjuge->data_nascimento = \Financi\DataFormat::DateDB($conjuge->data_nascimento);
                    unset($conjuge->residencia);
                    $cliente_conjuge = new \ClienteConjuge($conjuge);
                    $cliente_conjuge->save();
                }

                foreach ($telefones as $t) {
                    if(isset($t->ddd) && isset($t->tipo) && isset($t->numero)) {
                        $t->cliente_id = $cliente->id;
                        $telefone = new \ClienteTelefone($t);
                        $telefone->save();
                    }
                }

                foreach ($emails as $e) {
                    if(isset($e->tipo) && isset($e->email)) {
                        $e->cliente_id = $cliente->id;
                        $email = new \ClienteEmail($e);
                        $email->save();
                    }
                }

                return $this->app->response->setBody(json_encode( ['success' => true, 'obj' =>  ['id'=>$cliente->id, 'nome' => $cliente->nome] ] )); 
            }

        } else {

            $endereco = isset($data->endereco) ? $data->endereco : false;
            $conjuge = isset($data->conjuge) ? $data->conjuge : false;
            $telefones = isset($data->telefones) ? $data->telefones : [];
            $emails = isset($data->emails) ? $data->emails : [];

            unset($data->endereco);
            unset($data->conjuge);
            unset($data->telefones);
            unset($data->emails);
            $data->data_nascimento = \Financi\DataFormat::DateDB($data->data_nascimento);
            
            $cliente = \Clientes::find($data->id);

            $data->expedicao = \Financi\DataFormat::DateDB($data->expedicao);

            if($cliente->update_attributes($data)) {

                if($endereco) {
                    foreach ($endereco as $e) {
                        if(isset($e->id)) {
                            $cliente_endereco = \ClienteEndereco::find($e->id);
                            if(count($cliente_endereco)) {
                                $cliente_endereco->update_attributes($e);
                            }
                        } else {
                            $e->cliente_id = $cliente->id;
                            print_r($e);
                            $cliente_endereco = new \ClienteEndereco($e);
                            $cliente_endereco->save();
                        }
                    }
                }

                if($conjuge) {

                    $conjuge->expedicao = \Financi\DataFormat::DateDB($conjuge->expedicao);

                    if($conjuge->id) {
                        $cliente_conjuge = \ClienteConjuge::find($conjuge->id);
                        $cliente_conjuge->update_attributes($conjuge);
                    } else {
                        $conjuge->cliente_id = $cliente->id;
                        $cliente_conjuge = new \ClienteConjuge($conjuge);
                        $cliente_conjuge->save();
                    }

                }

                $remove_telefones = \ClienteTelefone::query("DELETE FROM cliente_telefone WHERE cliente_id = ?", [$cliente->id]);

                foreach ($telefones as $t) {
                    if(isset($t->ddd) && isset($t->tipo) && isset($t->numero)) {
                        $t->cliente_id = $cliente->id;
                        $telefone = new \ClienteTelefone($t);
                        $telefone->save();
                    }
                }

                $remove_emails = \ClienteEmail::query("DELETE FROM cliente_email WHERE cliente_id = ?", [$cliente->id]);

                foreach ($emails as $e) {
                    if(isset($e->tipo) && isset($e->email)) {
                        $e->cliente_id = $cliente->id;
                        $email = new \ClienteEmail($e);
                        $email->save();
                    }
                }

                return $this->app->response->setBody(json_encode( ['success' => true] ));

            }
        }
        
    }

    public function acoesAction($acao) 
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        $conn = \Clientes::connection();

        if($acao == 'excluir') {
            try {
                $conn->transaction();
                
                foreach ($data as $d) {
                    $cliente = \Clientes::find($d->id);

                    $teste = \Clientes::in_used($cliente, $d->id);
                    if($teste) {
                        throw new \Exception("Error Processing Request", 1);
                    }
                    
                    $cliente->delete();
                }

                $conn->commit();

                return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 2] ));
            } catch(\Exception $e) {
                $conn->rollback();

                return $this->app->response->setBody(json_encode( ['success' => false, 'msg' => 35] ));
            } 
        }

        if($acao == 'desabilitar') {
            foreach ($data as $d) {
                $cliente = \Clientes::find($d->id);
                $cliente->status = 2;
                if(count($cliente)) {
                    $cliente->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }

        if($acao == 'habilitar') {
            foreach ($data as $d) {
                $cliente = \Clientes::find($d->id);
                $cliente->status = 1;
                if(count($cliente)) {
                    $cliente->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }
    }

    public function queryAction($query)
    {
        $this->app->contentType('application/json');
        $clientes = \Clientes::find('all', [
                'conditions' => ['cliente.status = 1 AND cliente.nome like ?', '%'.$query.'%']
            ]);

        $arr = [];
        foreach ($clientes as $cliente) {
            $arr[] = $cliente->to_array();
        }

        return $this->app->response->setBody(json_encode( $arr ));
    }

    public function cpfCnpjAction($cpfcnpj)
    {
        $this->app->contentType('application/json');

        $cliente = \Clientes::find('one', [
                'conditions' => [ 'cpf = ? OR cnpj = ? AND status = 1', $cpfcnpj, $cpfcnpj ]
            ]);

        $r = [ 'success' => false ];
        if(count($cliente)) {
            $r = [ 'success' => true, 'id' => $cliente->id ];
        }

        return $this->app->response->setBody(json_encode( $r ));
    }


    public function cnaeAction() {
        $this->app->contentType('application/json');
        $get = $this->app->request->get();

        $cnae_total = \Cnae::find('all', [
                'conditions' => [ 'descricao like ?', '%' . $get['searchTerm'] . '%' ],
            ]);

        $inicio = ($get['pageSize']*$get['pageNum'])-$get['pageSize'];

        $cnae = \Cnae::find('all', [
                'conditions' => [ 'descricao like ?', '%' . $get['searchTerm'] . '%' ],
                'limit' => $get['pageSize'],
                'offset' => $inicio,
                'order' => 'descricao ASC'
            ]);

        $arr = [];

        if(count($cnae)) {
            foreach ($cnae as $c) {
                $arr[] = ['id' => $c->id, 'text' => utf8_encode($c->descricao) ];
            }
        }

        return $this->app->response->setBody(json_encode( [ 'Results' => $arr, 'Total' => count($cnae_total) ] ));
    }
}
