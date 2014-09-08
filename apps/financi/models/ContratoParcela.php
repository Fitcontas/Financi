<?php

class ContratoParcela extends AppModel
{
    static $table_name = 'contrato_parcela';

    static $belongs_to = [
        ['contrato', 'class_name' => 'Contrato', 'foreign_key' => 'contrato_id', 'primary_key' => 'id']
    ];

    static $has_many = [
        ['parcela_entrada', 'class_name' => 'ParcelaEntrada', 'foreign_key' => 'contrato_parcela_id', 'primary_key' => 'id']
    ];

}