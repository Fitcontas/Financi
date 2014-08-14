<?php 

class Empreendimento extends AppModel 
{
    static $table_name = 'empreendimento';
    static $has_many = [
        ['corretores', 'class_name' => 'EmpreendimentoCorretor', 'foreign_key' => 'empreendimento_id', 'primary_key' => 'id']
    ];
}