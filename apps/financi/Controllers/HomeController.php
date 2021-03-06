<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices,
    \PhpOffice\PhpWord\TemplateProcessor;

class HomeController extends \SlimController\SlimController 
{
	public function indexAction()
	{

        $templateProcessor = new TemplateProcessor(ROOT . DS . 'template.docx');
        $templateProcessor->setValue('empresa', 'Financi Empreendimentos LTDA');

        $templateProcessor->cloneBlock('CLIENTE', 3, true);

        $templateProcessor->saveAs(ROOT . DS . 'Sample_07_TemplateCloneRow.docx');


        $usuario = \Usuario::find(\Financi\Auth::getUser()['id']);

        $conditions = [ 'instituicao_id = ? and status <> 0', \Financi\Auth::getUser()['instituicao_id'] ];

        $conditions2 = [ 'status <> 0', \Financi\Auth::getUser()['instituicao_id'] ];

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

        $contratos = \Contrato::find('all', [
                'select' => 'count(*) as qtd, sum(valor) as valor',
                'conditions' => $conditions2
            ]);

        $lotes = \Lote::find('all', [
                'select' => 'count(*) as qtd',
                'conditions' => $conditions2
            ]);

        $lotes_vendidos = \Lote::find('all', [
                'select' => 'count(*) as qtd',
                'conditions' => [ 'situacao = ? AND status <> 0', 'V' ]
            ]);

        $lotes_reservas = \Lote::find('all', [
                'select' => 'count(*) as qtd',
                'conditions' => [ 'situacao = ? AND status <> 0', 'R' ]
            ]);

        $ultimos_contratos = \Contrato::find('all', [
                'conditions' => $conditions2,
                'limit' => 10
            ]);

        //dump_r($lotes_reservas);

		$this->render('home/index', array(
            'breadcrumb' => ['Mural'],
            'clientes' => $clientes,
            'empreendimentos' => $empreendimentos,
            'corretores' => $corretores,
            'contratos' => $contratos,
            'lotes' => $lotes,
            'lotes_vendidos' => $lotes_vendidos,
            'lotes_reservas' => $lotes_reservas,
            'ultimos_contratos' => $ultimos_contratos,
            //'title' => 'Financi Imóveis',
            'foot_css' => ['css/style_.css'],
            'head_js' => [ 'bower_components/angular-route/angular-route.min.js' ],
            'foot_js' => [ 'js/cadastros/usuario.js', 'bower_components/lodash/dist/lodash.min.js'],
            'is_home' => true,
            'trocar_senha' => $usuario->trocar_senha
        ));
	}

	public function loginAction()
	{

		$this->render('home/login', array(
			'layout' => 'login.php',
			//'title' => 'Financi Imóveis - Login',
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
					'select' => 'usuario.*, instituicao.id as instituicao_id, grupo_usuario.id as grupo_id',
					'joins' => ['instituicao', 'grupo_usuario'],
					'conditions' => ['(email = ? OR usuario = ?) and senha = ?', $usuario, $usuario, sha1($senha)]
				]);

			if(count($query) == 1) {
				if(\Financi\Auth::authentication($query->to_array())) {
                    if(\Financi\Auth::getUser()['grupo_id'] == 2) {
                        $this->redirect('/corretor-lotes');
                    }

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

        $get = $this->app->request->get();

        if(isset($get['cidade']) && $get['cidade']) {
            $cidade = WebServices::service('cidade/'.$get['cidade']);
            return $this->app->response->setBody(json_encode( ['cidades' => [$cidade->rows]] )); 
        }

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