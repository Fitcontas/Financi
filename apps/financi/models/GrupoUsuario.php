<?php

class GrupoUsuario extends AppModel
{
    static $table_name = 'grupo_usuario';
    static $has_many = [
        ['usuarios', 'class_name' => 'Usuario', 'foreign_key' => 'grupo_id', 'primary_key' => 'id'],
    ];
}