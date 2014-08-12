<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class Cliente extends \SlimController\SlimController 
{
	public function indexAction()
	{
        $clientes = \Clientes::find('all');

		$this->render('cliente/index.php', [
                'clientes' => $clientes,
            ]);
	}

    public function cadastroPfAction()
    {

        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('cliente/pf.php', [
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/clientes.js' ]
            ]);
    }

    public function cadastroPjAction()
    {
        $this->render('cliente/pj.php', [
               
            ]);
    }

    public function cidadesAction($uf)
    {
        $this->app->contentType('application/json');

        $cidades = WebServices::service('cidades_por_uf/' . $uf);

        return $this->app->response->setBody(json_encode( $cidades )); 
    }


    public function salvarPfAction()
    {
        $this->app->contentType('application/json');
        $data = json_decode($this->app->request->getBody('cliente'));
        $data->instituicao_id = 1;

        $endereco = isset($data->endereco) ? $data->endereco : [];

        unset($data->endereco);

        $cliente = new Clientes($data);
        
        if($cliente->save())
        {

            if(isset($endereco)) {
                foreach ($endereco as $e) {
                    $e->cliente_id = $cliente->id;
                    
                    $cliente_endereco = new ClienteEndereco($e);
                    $cliente_endereco->save();
                }
            }

            return $this->app->response->setBody(json_encode( ['success' => true] )); 
        }
        
    }
}
