<?php

class ContratoCorretor extends AppModel 
{
    static $table_name = 'contrator_corretor';

    static $belongs_to = [
        ['contrato', 'class_name' => 'Contrato', 'foreign_key' => 'contrato_id', 'primary_key' => 'id'],
        ['corretor', 'class_name' => 'Corretor', 'foreign_key' => 'corretor_id', 'primary_key' => 'id']
    ];
}