<?php

class ContratoCliente extends AppModel 
{
    static $table_name = 'contrato_cliente';

    static $belongs_to = [
        ['contrato', 'class_name' => 'Contrato', 'foreign_key' => 'contrato_id', 'primary_key' => 'id'],
        ['cliente', 'class_name' => 'Cliente', 'foreign_key' => 'cliente_id', 'primary_key' => 'id']
    ];
}