<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class UsuarioController extends \SlimController\SlimController 
{
    public function indexAction()
    {   
        $usuario = \Usuario::find('all');

        $this->render('usuario/index.php', [
                'usuario' => $usuario,
                'head_js' => [ 'bower_components/angular-route/angular-route.min.js' ],
                'foot_js' => [ 'js/cadastros/usuario.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $conditions = ['usuario.status <> ?', 0];

        if($get['query']) {
            $query = new \Usuario();
            $pks = $query->search($get['query']);
            if(count($pks)) {
                $conditions = ['usuario.id in(?) AND usuario.status <> ?', $pks, 0];
            } else {
                return $this->app->response->setBody(json_encode( [ 'search'=>false, 'paginas' => 1] )); 
            }
        }

        $usuarios_total = \Usuario::find('all', [
                'select' => 'usuario.id, usuario.usuario, usuario.nome, usuario.apelido, usuario.email, usuario.grupo_id, usuario.status, grupo_usuario.descricao as grupo',
                'joins' => ['grupo_usuario'],
                'conditions' => $conditions
            ]);

        $pagina = $get['pagina'];

        $limite = PAGE_LIMIT;

        $total = count($usuarios_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        $usuarios = \Usuario::find('all', [
                'select' => 'usuario.id, usuario.usuario, usuario.nome, usuario.apelido, usuario.email, usuario.grupo_id, usuario.status, grupo_usuario.descricao as grupo',
                'joins' => ['grupo_usuario'],
                'conditions' => $conditions,
                'limit' => $limite,
                'offset' => $inicio
            ]);

        $arr = [];

        foreach ($usuarios as $u) {
            $u_arr = $u->to_array();
            $u_arr['email2'] = $u_arr['email'];
            unset($u_arr['senha']);
            $arr[] = $u_arr;
        }

        $pagination = [
            'paginas' => $total_paginas, 
            'limite' => $limite, 
            'inicio' => $inicio, 
            'total_pagina'=>count($usuarios), 
            'total_geral'=>count($usuarios_total)
        ];

        return $this->app->response->setBody(json_encode( ['usuarios' => $arr, 'pagination' => $pagination] ));
    }

    public function novoAction()
    {   

        $this->app->contentType('application/json');

        $data = json_decode($this->app->request->getBody());

        if(isset($data->id)) {
            $usuario = \Usuario::find($data->id);
            $usuario->usuario = $data->email;
            $usuario->email = $data->email;
            $usuario->apelido = $data->apelido;
            $usuario->nome = $data->nome;
            $usuario->grupo_id = $data->grupo_id;
            
            if($usuario->save()) {
                return $this->app->response->setBody(json_encode( ['success' => true] )); 
            }
        } else {
            $usuario = new \Usuario();
            $usuario->usuario = $data->email;
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

    public function acoesAction($acao) 
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody());

        if($acao == 'excluir') {
            foreach ($data as $d) {
                $usuario = \Usuario::find($d->id);
                $usuario->status = 0;
                if(count($usuario)) {
                    $usuario->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 2] )); 
        }

        if($acao == 'desabilitar') {
            foreach ($data as $d) {
                $usuario = \Usuario::find($d->id);
                $usuario->status = 2;
                if(count($usuario)) {
                    $usuario->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }

        if($acao == 'habilitar') {
            foreach ($data as $d) {
                $usuario = \Usuario::find($d->id);
                $usuario->status = 1;
                if(count($usuario)) {
                    $usuario->save();
                }
            }
            return $this->app->response->setBody(json_encode( ['success' => true, 'msg' => 4] )); 
        }
    }

    public function gruposAction()
    {
        $this->app->contentType('application/json');
        $grupos = \GrupoUsuario::find('all');

        $grupos_arr = [];

        if(count($grupos)) {
            foreach ($grupos as $g) {
                $grupos_arr[] = $g->to_array();
            }
        }

        return $this->app->response->setBody(json_encode( ['grupos' => $grupos_arr] )); 
    }
}