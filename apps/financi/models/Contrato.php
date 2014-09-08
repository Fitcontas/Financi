<?php

class Contrato extends AppModel 
{
    static $table_name = 'contrato';

    static $belongs_to = [
        ['instituicao', 'class_name' => 'Instituicao', 'foreign_key' => 'instituicao_id', 'primary_key' => 'id'],
        ['lote', 'class_name' => 'Lote', 'foreign_key' => 'lote_id', 'primary_key' => 'id']
    ];

    static $has_many = [
        ['contrato_parcela', 'class_name' => 'ContratoParcela', 'foreign_key' => 'contrato_id', 'primary_key' => 'id'],
        ['contrato_corretor', 'class_name' => 'ContratoCorretor', 'foreign_key' => 'contrato_id', 'primary_key' => 'id'],
        ['contrato_cliente', 'class_name' => 'ContratoCliente', 'foreign_key' => 'contrato_id', 'primary_key' => 'id']
    ];
}