<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class Usuario extends \SlimController\SlimController 
{
    public function indexAction()
    {
        $usuario = \Usuario::find('all');

        $this->render('usuario/index.php', [
                'usuario' => $usuario,
                'foot_js' => ['js/cadastros/usuario.js']
            ]);
    }

    public function allAction()
    {
        $this->app->contentType('application/json');
        
        $usuarios = \Usuario::find('all', [
                'select' => 'usuario.*, grupo_usuario.descricao as grupo',
                'joins' => ['grupo_usuario']
            ]);

        $arr = [];

        foreach ($usuarios as $u) {
            $u_arr = $u->to_array();
            $u_arr['email2'] = $u_arr['email'];
            unset($u_arr['senha']);
            $arr[] = $u_arr;
        }

        return $this->app->response->setBody(json_encode( ['usuarios' => $arr] ));
    }

    public function novoAction()
    {   

        $this->app->contentType('application/json');

        $data = json_decode($this->app->request->getBody());

        if(isset($data->id)) {
            $usuario = \Usuario::find($data->id);
            $usuario->usuario = $data->usuario;
            $usuario->email = $data->email;
            $usuario->apelido = $data->apelido;
            $usuario->nome = $data->nome;
            $usuario->grupo_id = $data->grupo_id;
            
            if($usuario->save()) {
                return $this->app->response->setBody(json_encode( ['success' => true] )); 
            }
        } else {
            $usuario = new \Usuario();
            $usuario->usuario = $data->usuario;
            $usuario->email = $data->email;
            $usuario->apelido = $data->apelido;
            $usuario->nome = $data->nome;
            $usuario->grupo_id = $data->grupo_id;
            $usuario->instituicao_id = 1;
            $usuario->senha = sha1($data->senha);

            if($usuario->save()) {
                return $this->app->response->setBody(json_encode( ['success' => true] )); 
            }
        }

        return $this->app->response->setBody(json_encode( ['success' => false] ));
    }
}