<?php

class Instituicao extends AppModel
{
    static $table_name = 'instituicao';
    static $has_many = [
        ['usuarios', 'class_name' => 'Usuario', 'foreign_key' => 'instituicao_id', 'primary_key' => 'id'],
    ];
}