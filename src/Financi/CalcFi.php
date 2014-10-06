<?php

namespace Financi;

use \Financi\DataFormat;

class CalcFi {
    private $valor_contrato;
    private $tipo_entrada;
    private $entrada;
    private $tipo_intermediaria;
    private $intermediaria;
    private $taxa_mensal;
    private $meses_periodo;
    private $periodo_intermerdiaria;
    private $qtd_parcelas;
    private $parcela_intermediaria;
    private $qtd_parcelas_intermediaria;

    public function __construct()
    {
        $this->tipo_entrada = 1;
        $this->tipo_intermediaria = 1;

        $this->meses_periodo = [
            1=>1,
            2=>2,
            3=>3,
            4=>4,
            5=>6,
            6=>12
        ];

    }

    public function __set($key, $value) 
    {
        $this->$key = $value;

        return $this;
    }

    public function getEntrada()
    {
        return $this->tipo_entrada == 1 && $this->entrada > 0 ? DataFormat::money($this->entrada) / 100 : DataFormat::money($this->entrada);
    }

    public function getIntermediaria()
    {
        return $this->tipo_intermediaria == 1 ? ((DataFormat::money($this->intermediaria) / 100) * $this->valor_contrato) : DataFormat::money($this->intermediaria);
    }

    public function TaxaEquivalente()
    {
        $taxa_soma = (1 + $this->taxa_mensal);
        $taxa_exp = pow($taxa_soma, $this->meses_periodo[$this->periodo_intermerdiaria]);
        return $taxa_exp - 1;
    }

    public function QtdParcelasIntermediaria()
    {
        return $this->qtd_parcelas / $this->meses_periodo[$this->periodo_intermerdiaria];
    }

    public function PvIntermediaria() 
    {

        if($this->tipo_intermediaria == 1) {
            $pv = $this->getIntermediaria();

            $this->parcela_intermediaria = ($this->getIntermediaria() / $this->QtdParcelasIntermediaria());
        } else if($this->tipo_intermediaria == 2) {

            $pv1 = (pow( (1 + $this->TaxaEquivalente()), $this->QtdParcelasIntermediaria())) * $this->TaxaEquivalente();
            $pv2 = (pow( (1 + $this->TaxaEquivalente()), $this->QtdParcelasIntermediaria())) - 1;
            $pv = ($this->getIntermediaria() / $this->QtdParcelasIntermediaria()) / ($pv1 / $pv2);

            $this->parcela_intermediaria = ($this->getIntermediaria() / $this->QtdParcelasIntermediaria());
        }

        return $pv;
    }

    public function getParcelaIntermediaria()
    {
        return $this->parcela_intermediaria;
    }

    public function getDiferencaIntermediaria()
    {
        $inter =  number_format($this->parcela_intermediaria, 2, '.', '') * $this->QtdParcelasIntermediaria();
        
        $diferenca = $this->getIntermediaria() - $inter;

        return $diferenca;
    }
}