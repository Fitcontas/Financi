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
}