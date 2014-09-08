<?php

class ParcelaEntrada extends AppModel 
{
    static $table_name = 'parcela_entrada';

    static $belongs_to = [
        ['contrato_parcela', 'class_name' => 'ContratoParcela', 'foreign_key' => 'contrato_parcela_id', 'primary_key' => 'id']
    ];
}