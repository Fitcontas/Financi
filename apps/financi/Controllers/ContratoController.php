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
                'foot_js' => [ 'js/maskMoney/jquery.maskMoney.min.js', 'js/mask.js', 'bower_components/lodash/dist/lodash.min.js', 'bower_components/accounting/accounting.min.js', 'js/contrato/contrato.js' ]
            ]);

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
}