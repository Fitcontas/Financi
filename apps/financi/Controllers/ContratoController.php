<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices,
    \Financi\CalcFi;

class ContratoController extends \SlimController\SlimController 
{
    public function indexAction()
    {
        $empreendimentos = \Empreendimento::find('all', [
                'conditions' => [ 'instituicao_id = ? and status = 1', \Financi\Auth::getUser()['instituicao_id']]
            ]);

        $clientes = \Clientes::find('all', [
                'conditions' => [ 'instituicao_id = ? and status = 1', \Financi\Auth::getUser()['instituicao_id']]
            ]);

        $corretores = \Corretor::find('all', [
                'conditions' => [ 'instituicao_id = ? and status = 1', \Financi\Auth::getUser()['instituicao_id']]
            ]);

        $periodos = [
            1=>'Mensal',
            2=>'Bimestral',
            3=>'Trimestral',
            4=>'Quatrimestral',
            5=>'Semestral',
            6=>'Anual'
        ];

        $this->render('contrato/index.php', [
                'breadcrumb' => ['Lançamentos', 'Contratos'],
                'empreendimentos' => $empreendimentos,
                'clientes' => $clientes,
                'corretores' => $corretores,
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'js/mask.js', 'bower_components/lodash/dist/lodash.min.js', 'bower_components/accounting/accounting.min.js', 'bower_components/moment/min/moment.min.js', 'js/contrato/contrato.js' ]
            ]);

    }

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $conditions = ['contrato.status <> ?', 0];

        if($get['query']) {
            $query = new \Contrato();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['contrato.id in(?) AND contrato.status <> ?', $pks, 0];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1] )); 
            }
        }

        $contratos_total = \Contrato::find('all', [
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = PAGE_LIMIT;

        $total = count($contratos_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        if(isset($get['column']) && isset($get['sort'])) {
            $sort = $get['column'] . ' ' . $get['sort'];
        } else {
            $sort = '';
        }

        $contratos = \Contrato::find('all', [
                'select' => 'contrato.*, c.nome',
                'joins'=> [ 'INNER JOIN contrato_cliente cc ON cc.contrato_id = contrato.id INNER JOIN cliente c ON c.id = cc.cliente_id' ],
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio,
                'group' => 'contrato.id',
                'order' => $sort
            ]);

        $arr = [];

        foreach ($contratos as $e) {
            $data_emissao = $e->data_emissao->format('Y');

            $final_arr = $e->to_array();
            $final_arr['valor'] = number_format($final_arr['valor'], 2, ',', '.');
            $final_arr['data_emissao'] = \Financi\DataFormat::showDate($final_arr['data_emissao']);
            $final_arr['contrato'] = str_pad( $final_arr['id'].$data_emissao, 9, 0, STR_PAD_LEFT);
            
            foreach($e->contrato_cliente as $cliente) {
                $final_arr['clientes'][] = $cliente->cliente->to_array();
            }

            $arr[] = $final_arr;
        }

        $pagination = [
            'paginas' => $total_paginas, 
            'limite' => $limite, 
            'inicio' => $inicio, 
            'total_pagina'=>count($contratos), 
            'total_geral'=>count($contratos_total)
        ];

        return $this->app->response->setBody(json_encode( ['contratos' => $arr, 'pagination' => $pagination] ));
    }

    public function parcelasAction()
    {
        $this->app->contentType('application/json');

        $meses_periodo = [
            1=>1,
            2=>2,
            3=>3,
            4=>4,
            5=>6,
            6=>12
        ];

        $data = json_decode($this->app->request->getBody());

        //Pegando o empreendimento
        $empreendimento = \Empreendimento::find($data->empreendimento_id);
        $taxa = $empreendimento->taxa_financiamento / 100;

        $valor_contrato = \Financi\DataFormat::money($data->valor_contrato);

        //Passandos dados ao CalcFi
        $calc = new CalcFi();
        $calc->entrada = $data->entrada;
        $calc->tipo_entrada = $data->tipo_entrada;
        $calc->valor_contrato = $valor_contrato;
        $calc->tipo_intermediaria = $data->tipo_intermediarias;
        $calc->intermediaria = $data->intermediarias;
        $calc->taxa_mensal = $empreendimento->taxa_financiamento / 100;
        $calc->periodo_intermerdiaria = $data->periodo;
        $calc->qtd_parcelas = $data->parcelas;

        $pct_entrada = $calc->getEntrada();
        
        $qtd_parcelas = $data->parcelas;
        $periodo = $data->periodo;

        $vl_entrada = $data->tipo_entrada == 1 ? ($valor_contrato * $pct_entrada) : $pct_entrada;

        $vl_intermediarias = $calc->getIntermediaria();

        //Intermerdiárias
        $valor_intermediarias = $calc->PvIntermediaria();

        $valor_financiado = $valor_contrato - ( $vl_entrada + $calc->PvIntermediaria() );

        $fase1 = 1 - pow((1+$taxa), ($qtd_parcelas * -1));
        $parcelas = $valor_financiado / ($fase1 / $taxa);

        //print_r($parcelas);
        //exit();
        
        $qtd_periodos = $qtd_parcelas / $meses_periodo[$periodo];

        
        
        //taxa equivalente
        $taxa_equivalente = pow((1 + $taxa), $meses_periodo[$periodo]) - 1;
        


        $intermediarias = $calc->getParcelaIntermediaria();

        //$int_valor_inicial = ( $valor_intermediarias / pow((1 + $taxa_equivalente),  $qtd_periodos) );

        //print_r( $qtd_periodos );
        //exit();

        

        //echo $data->tipo_intermediarias;
        //echo $calc->getParcelaIntermediaria();
        //exit();

        $primeiro_vencimento = implode("-", array_reverse(explode("/", $data->primeiro_vencimento)));
        $primeiro_vencimento = new \DateTime($primeiro_vencimento);

        $array = [];

        $periodo_controle = $meses_periodo[$periodo];
        
        $index = 2;
        $p=1;
        for ($i=1; $i <= $qtd_parcelas ; $i++) {
            $intervalo = new \DateInterval('P1M'); 
            $vencimento =  $primeiro_vencimento->add($intervalo)->format('d/m/Y');
            $ano = $primeiro_vencimento->format('Y');
            
            $pad_parcela = str_pad($index, 3, '0', STR_PAD_LEFT) . '/' . $ano;

            $array[] = [ 'num' => str_pad($index, 3, '0', STR_PAD_LEFT), 'parcela' => $pad_parcela, 'vencimento' => $vencimento, 'valor' => number_format($parcelas, 2, ',', '.') ];
            if($i == $periodo_controle && $intermediarias > 0) {
                $index++;

                $pad_parcela = str_pad($index, 3, '0', STR_PAD_LEFT) . '/' . $ano.'INT';

                //$intermediarias = $p == 1 ? $intermediarias + $calc->getDiferencaIntermediaria() : $intermediarias;

                $array[] = [ 'num' => str_pad($index, 3, '0', STR_PAD_LEFT), 'parcela' => $pad_parcela, 'vencimento' => $vencimento, 'valor' => number_format($intermediarias, 2, ',', '.'), 'int'=>true ];

                $periodo_controle += $meses_periodo[$periodo];
                $p++;
            }
            $index++;
        }

        return $this->app->response->setBody(json_encode( $array )); 
    }

    public function novoAction()
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        $entradas_config = $data->contrato->entrada_config->entradas;

        if(isset($data->contrato->id)) {
            $busca = \Contrato::find($data->contrato->id);
            $busca->delete();
            $contrato_data['id'] = $data->contrato->id;
        }
        
        $contrato_data = [
            'lote_id' => $data->contrato->lote_id,
            'instituicao_id' => \Financi\Auth::getUser()['instituicao_id'],
            'desconto' => \Financi\DataFormat::money($data->contrato->desconto),
            'entrada' => \Financi\DataFormat::money($data->contrato->entrada),
            'intermediarias' => \Financi\DataFormat::money($data->contrato->intermediarias),
            'intervalo_intermediarias' => $data->contrato->periodo,
            'qtd_parcelas' => $data->contrato->parcelas,
            'primeiro_vencimento' => \Financi\DataFormat::DateDB($data->contrato->primeiro_vencimento),
            'data_emissao' => \Financi\DataFormat::DateDB($data->contrato->emissao),
            'valor' => \Financi\DataFormat::money($data->contrato->valor_contrato),
            'entrada_config' => json_encode($data->contrato->entrada_config),
            'tipo_entrada' => $data->contrato->tipo_entrada,
            'tipo_intermediarias' => $data->contrato->tipo_intermediarias,
            'tipo_desconto' => $data->contrato->tipo_desconto
        ];

        $contrato = new \Contrato($contrato_data);

        if($contrato->save()) {

            $lote = \Lote::find($data->contrato->lote_id);
            $lote->situacao = 'V';
            $lote->save();

            foreach ($data->contrato->corretores as $c) {
                $corretor = new \ContratoCorretor();
                $corretor->contrato_id = $contrato->id;
                $corretor->corretor_id = $c->corretor_id;
                $corretor->comissao = \Financi\DataFormat::money($c->comissao);
                $corretor->save();
            }

            foreach ($data->contrato->clientes as $c) {
                $cliente = new \ContratoCliente();
                $cliente->contrato_id = $contrato->id;
                $cliente->cliente_id = $c->cliente_id;
                $cliente->participacao = \Financi\DataFormat::money($c->porcentagem);
                $cliente->save();
            }

            $parcela_entrada = new \ContratoParcela();
            $parcela_entrada->contrato_id = $contrato->id;
            $parcela_entrada->numero = '001';
            $parcela_entrada->valor = \Financi\DataFormat::money($data->contrato->entrada_config->total);
            
            if($parcela_entrada->save()) {
                foreach ($entradas_config as $entrada) {
                    if($entrada->tipo == 1) {
                        $nova_entrata = new \ParcelaEntrada();
                        $nova_entrata->contrato_parcela_id = $parcela_entrada->id;
                        $nova_entrata->tipo = 1;
                        $nova_entrata->valor = \Financi\DataFormat::money($entrada->valor);
                        $nova_entrata->save();
                    } else if($entrada->tipo == 2) {
                        if(!count($entrada->itens->parcelas)) {
                            $nova_entrata = new \ParcelaEntrada();
                            $nova_entrata->contrato_parcela_id = $parcela_entrada->id;
                            $nova_entrata->tipo = 2;
                            $nova_entrata->forma = 1;
                            $nova_entrata->numero_cheque = $entrada->itens->numero_cheque;
                            $nova_entrata->vencimento = \Financi\DataFormat::DateDB($entrada->itens->cheque_vencimento);
                            $nova_entrata->valor = \Financi\DataFormat::money($entrada->valor);
                            $nova_entrata->save();
                        } else {
                            foreach ($entrada->itens->parcelas as $predatado) {
                                $nova_entrata = new \ParcelaEntrada();
                                $nova_entrata->contrato_parcela_id = $parcela_entrada->id;
                                $nova_entrata->tipo = 2;
                                $nova_entrata->forma = 2;
                                $nova_entrata->numero_cheque = $predatado->numero;
                                $nova_entrata->vencimento = \Financi\DataFormat::DateDB($predatado->vencimento);
                                $nova_entrata->valor = \Financi\DataFormat::money($predatado->valor);
                                $nova_entrata->save();
                            }
                        }

                    }
                }
            }

            foreach ($data->parcelas as $p) {
                $nova_parcela = new \ContratoParcela();
                $nova_parcela->contrato_id = $contrato->id;
                $nova_parcela->numero = $p->num;
                $nova_parcela->vencimento = \Financi\DataFormat::DateDB($p->vencimento);
                $nova_parcela->valor = \Financi\DataFormat::money($p->valor);
                $nova_parcela->intermediaria = isset($p->int) ? true : false;
                $nova_parcela->save();
            }

        }
        return $this->app->response->setBody(json_encode( ['success' => true] ));
    }


    public function acoesAction($acao) 
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        if($acao == 'excluir') {
            foreach ($data as $d) {
                
                $contrato = \Contrato::find($d->id);

                $lote = \Lote::find($contrato->lote_id);
                $lote->situacao = null;
                $lote->save();
               
                if($contrato->delete()) {
                    return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 2] )); 
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 2] )); 
        }
    }

    public function getEditAction($id) {
        $this->app->contentType('application/json');
        
        if($id) {
            $contrato = \Contrato::find($id);

            if(count($contrato)) {

                $contrato_arr = $contrato->to_array();
                $contrato_arr['emissao'] = $contrato->data_emissao->format('d/m/Y');
                $contrato_arr['primeiro_vencimento'] = $contrato->primeiro_vencimento->format('d/m/Y');
                $contrato_arr['desconto'] = \Financi\DataFormat::showMoney($contrato->desconto);
                $contrato_arr['valor_contrato'] = \Financi\DataFormat::showMoney($contrato->valor);
                $contrato_arr['empreendimento_id'] = $contrato->lote->empreendimento_id;

                $lote = \Lote::find($contrato->lote_id);

                $contrato_arr['area_total'] = \Financi\DataFormat::showMoney($lote->area_total);
                $contrato_arr['valor'] = \Financi\DataFormat::showMoney($lote->valor);
                $contrato_arr['entrada'] = \Financi\DataFormat::showMoney($contrato->entrada);
                $contrato_arr['intermediarias'] = \Financi\DataFormat::showMoney($contrato->intermediarias);
                $contrato_arr['periodo'] = $contrato->intervalo_intermediarias;
                $contrato_arr['parcelas'] = $contrato->qtd_parcelas;


                $clientes = [];
                foreach ($contrato->contrato_cliente as $cc) {
                    $arr_cc = $cc->to_array();
                    $arr_cc['porcentagem'] = \Financi\DataFormat::showMoney($cc->participacao);
                    $clientes[] = $arr_cc;
                }

                $contrato_arr['clientes'] = $clientes;

                $corretores = [];
                foreach ($contrato->contrato_corretor as $cc) {
                    $arr_cc = $cc->to_array();
                    $arr_cc['comissao'] = \Financi\DataFormat::showMoney($cc->comissao);
                    $corretores[] = $arr_cc;
                }

                $contrato_arr['corretores'] = $corretores;

                $empreendimento = \Empreendimento::find($contrato->lote->empreendimento_id);

                $arr_corretores = [];

                foreach ($empreendimento->corretores as $c) {
                    $arr_corretores[] = ['id' => $c->corretor_id, 'nome' => $c->corretor->nome];
                }

                $teste = json_decode($contrato->entrada_config);
                //print_r($teste);
                //exit();
                $contrato_arr['entrada_config'] = $teste;

                return $this->app->response->setBody(json_encode( ['success' => true, 'contrato' => $contrato_arr, 'lote' => [$lote->to_array()], 'corretores' => $arr_corretores, 'empreendimento' => $empreendimento->to_array() ] )); 
            }
        }
    }

}