<?php

namespace Controllers;

use Opis\Session\Session;

class EmpreendimentoController extends \SlimController\SlimController
{
    public function indexAction()
    {
        $this->render('empreendimento/index.php', [
                'foot_js' => [ 'js/cadastros/empreendimento.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }

    public function allAction()
    {
        $this->app->contentType('application/json');

        $get = $this->app->request->get();

        $empreendimentos_total = \Empreendimento::find('all', [
                'conditions' => ['empreendimento.status = ? OR empreendimento.status = ?', 1, 2]
            ]);

        $pagina = $get['pagina'];

        $limite = 10;

        $total = count($empreendimentos_total);

        $total_paginas = ceil($total/$limite);

        $inicio = ($limite*$pagina)-$limite;

        $empreendimentos = \Empreendimento::find('all', [
                'conditions' => ['empreendimento.status = ? OR empreendimento.status = ?', 1, 2],
                'limit' => $limite,
                'offset' => $inicio
            ]);

        $arr = [];

        foreach ($empreendimentos as $u) {
            $u_arr = $u->to_array();
            $arr[] = $u_arr;
        }

        return $this->app->response->setBody(json_encode( ['empreendimentos' => $arr, 'paginas' => $total_paginas] ));
    }
}