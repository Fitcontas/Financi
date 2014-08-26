<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class HomeController extends \SlimController\SlimController 
{
	public function indexAction()
	{

        $conditions = [ 'instituicao_id = ? and status <> 0', \Financi\Auth::getUser()['instituicao_id'] ];

        $clientes = \Clientes::find('one', [
                'select' => 'count(*) as qtd',
                'conditions' => $conditions
            ]);

        $empreendimentos = \Empreendimento::find('one', [
                'select' => 'count(*) as qtd',
                'conditions' => $conditions
            ]);

        $corretores = \Corretor::find('one', [
                'select' => 'count(*) as qtd',
                'conditions' => $conditions
            ]);

		$this->render('home/index', array(
            'clientes' => $clientes,
            'empreendimentos' => $empreendimentos,
            'corretores' => $corretores,
            'title' => 'Financi Imóveis',
            'foot_css' => ['css/style_.css']
        ));
	}

	public function loginAction()
	{

		$this->render('home/login', array(
			'layout' => 'login.php',
			'title' => 'Financi Imóveis - Login',
			'head_css' => ['css/login.css']
		));
	}

	public function logarAction()
	{
		$request = $this->request();
		$usuario = $request->params('email');
		$senha 	 = $request->params('senha');

		if($usuario && $senha) {
			$query = \Usuario::find('one', [
					'select' => 'usuario.*, instituicao.*, grupo_usuario.*',
					'joins' => ['instituicao', 'grupo_usuario'],
					'conditions' => ['email = ? OR usuario = ? and senha = ?', $usuario, $usuario, sha1($senha)]
				]);

			if(count($query) == 1) {
				if(\Financi\Auth::authentication($query->to_array())) {
					$this->redirect('/');
				}
			}
			
		}

		$flash = new \Financi\Flash();
		$flash->set('error', 'Usuário e senha inválidos.');

		$this->redirect('/login');
	}

	public function sairAction() {
		if(\Financi\Auth::logout()) {
			$this->redirect('/');
		}
	}

	public function cidadesAction($uf)
    {
        $this->app->contentType('application/json');

        $cidades = WebServices::service('cidades_por_uf/' . $uf);

        return $this->app->response->setBody(json_encode( ['cidades' => $cidades->rows] )); 
    }

    public function estadosAction()
    {
        $this->app->contentType('application/json');

        $estados = WebServices::service('estados');

        return $this->app->response->setBody(json_encode( ['ufs' => $estados->rows] )); 
    }
}