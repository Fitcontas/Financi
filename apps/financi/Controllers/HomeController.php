<?php

namespace Controllers;

use Opis\Session\Session;

class HomeController extends \SlimController\SlimController 
{
	public function indexAction()
	{
		$this->render('home/index', array(
            'title' => 'Financi Imóveis'
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
}