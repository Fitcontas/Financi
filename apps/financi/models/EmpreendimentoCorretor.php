<?php 

class EmpreendimentoCorretor extends AppModel 
{
    static $table_name = 'empreendimento_corretor';
    static $belongs_to = [
        ['corretor', 'class_name' => 'Corretor', 'foreign_key' => 'corretor_id', 'primary_key' => 'id'],
        ['empreendimento', 'class_name' => 'Empreendimento', 'foreign_key' => 'empreendimento_id', 'primary_key' => 'id']
    ];
}