<?php

namespace Controllers;

use Opis\Session\Session,
    \Financi\WebServices;

class CorretorController extends \SlimController\SlimController 
{
    public function indexAction()
    {
        $corretores = \Corretor::find('all');

        $this->render('corretor/index.php', [
                'corretores' => $corretores,
            ]);
    }

    public function novoAction()
    {

        $ufs = WebServices::service('estados', ['key' => 'uf', 'value' => 'uf']);

        $this->render('corretor/novo.php', [
                'ufs' => is_array($ufs) ? $ufs : [],
                'foot_js' => [ 'js/cadastros/clientes.js' ]
            ]);
    }

    public function corretoresAction()
    {
        $this->app->contentType('application/json');

        $corretores = \Corretor::find('all', [
                'select' => 'corretor.id, corretor.nome',
                'conditions' => ['status = 1']
            ]);

        $array = [];

        if (count($corretores)) {
            foreach ($corretores as $c) {
                $array[] = $c->to_array();
            }
        }

        $this->app->response->setBody(json_encode( ['corretores' => $array] )); 
    }
}