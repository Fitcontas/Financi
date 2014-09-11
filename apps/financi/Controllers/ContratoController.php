<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

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
                'empreendimentos' => $empreendimentos,
                'corretores' => $corretores,
                'clientes' => $clientes,
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

        $contratos = \Contrato::find('all', [
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio
            ]);

        $arr = [];

        foreach ($contratos as $e) {
            $data_emissao = $e->data_emissao->format('Y');

            $final_arr = $e->to_array();
            $final_arr['valor'] = number_format($final_arr['valor'], 2, ',', '.');
            $final_arr['data_emissao'] = \Financi\DataFormat::showDate($final_arr['data_emissao']);
            $final_arr['contrato'] = str_pad( $final_arr['id'].date('Y', $data_emissao), 9, 0, STR_PAD_LEFT);
            
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

        $valor_contrato = \Financi\DataFormat::money($data->valor_contrato);
        $pct_entrada = \Financi\DataFormat::money($data->entrada) / 100;
        $pct_intermediarias = \Financi\DataFormat::money($data->intermediarias) / 100;
        $qtd_parcelas = $data->parcelas;
        $periodo = $data->periodo;

        $empreendimento = \Empreendimento::find($data->empreendimento_id);
        $taxa = $empreendimento->taxa_financiamento / 100;

        $valor_financiado = $valor_contrato - ( ($valor_contrato * $pct_entrada) + ($valor_contrato * $pct_intermediarias) );

        $fase1 = 1 - pow((1+$taxa), ($qtd_parcelas * -1));
        $parcelas = $valor_financiado / ($fase1 / $taxa);

        //Intermerdiárias
        $valor_intermediarias = ($valor_contrato * $pct_intermediarias);
        $qtd_periodos = $qtd_parcelas /  $meses_periodo[$periodo];
        
        //taxa equivalente
        $taxa_equivalente = pow((1 + $taxa), $meses_periodo[$periodo]) - 1;
        
        $fase2 = 1 - pow((1 + $taxa_equivalente), ($qtd_periodos * -1));
        
        $intermediarias = $valor_intermediarias / ($fase2 / $taxa_equivalente);

        $primeiro_vencimento = implode("-", array_reverse(explode("/", $data->primeiro_vencimento)));
        $primeiro_vencimento = new \DateTime($primeiro_vencimento);

        

        $array = [];

        $periodo_controle = $meses_periodo[$periodo];
        $index = 2;
        for ($i=1; $i <= $qtd_parcelas ; $i++) {
            $intervalo = new \DateInterval('P1M'); 
            $vencimento =  $primeiro_vencimento->add($intervalo)->format('d/m/Y');
            $ano = $primeiro_vencimento->format('Y');
            
            $pad_parcela = str_pad($index, 3, '0', STR_PAD_LEFT) . '/' . $ano;

            $array[] = [ 'num' => str_pad($index, 3, '0', STR_PAD_LEFT), 'parcela' => $pad_parcela, 'vencimento' => $vencimento, 'valor' => number_format($parcelas, 2, ',', '.') ];
            if($i == $periodo_controle) {
                $index++;
                $pad_parcela = str_pad($index, 3, '0', STR_PAD_LEFT) . '/' . $ano.'INT';
                $array[] = [ 'num' => str_pad($index, 3, '0', STR_PAD_LEFT), 'parcela' => $pad_parcela, 'vencimento' => $vencimento, 'valor' => number_format($intermediarias, 2, ',', '.'), 'int'=>true ];
                $periodo_controle += $meses_periodo[$periodo];
            }
            $index++;
        }

        return $this->app->response->setBody(json_encode( $array )); 
    }

    public function novoAction()
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        $contrato_data = [
            'lote_id' => $data->lote_id,
            'instituicao_id' => \Financi\Auth::getUser()['instituicao_id'],
            'desconto' => \Financi\DataFormat::money($data->desconto),
            'entrada' => \Financi\DataFormat::money($data->entrada),
            'intermediarias' => \Financi\DataFormat::money($data->intermediarias),
            'intervalo_intermediarias' => $data->periodo,
            'qtd_parcelas' => $data->parcelas,
            'primeiro_vencimento' => \Financi\DataFormat::DateDB($data->primeiro_vencimento),
            'data_emissao' => \Financi\DataFormat::DateDB($data->emissao),
        ];

        $contrato = new \Contrato($contrato_data);

        if($contrato->save()) {

            foreach ($data->corretores as $c) {
                $corretor = new \ContratoCorretor();
                $corretor->contrato_id = $contrato->id;
                $corretor->corretor_id = $c->corretor_id;
                $corretor->comissao = \Financi\DataFormat::money($c->comissao);
                $corretor->save();
            }

            foreach ($data->clientes as $c) {
                $cliente = new \ContratoCliente();
                $cliente->contrato_id = $contrato->id;
                $cliente->cliente_id = $c->cliente_id;
                $cliente->participacao = \Financi\DataFormat::money($c->porcentagem);
                $cliente->save();
            }

        }
        return $this->app->response->setBody(json_encode( ['success' => true] ));
    }

}