<?php

class Usuario extends AppModel {
	static $table_name = 'usuario';
    static $belongs_to = [
        ['grupo_usuario', 'class_name' => 'GrupoUsuario', 'foreign_key' => 'grupo_id', 'primary_key' => 'id'],
        ['instituicao', 'class_name' => 'Instituicao', 'foreign_key' => 'instituicao_id', 'primary_key' => 'id']
    ];
}