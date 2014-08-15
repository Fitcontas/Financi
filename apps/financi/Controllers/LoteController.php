<?php

namespace Controllers;

class LoteController extends SlimController\SlimController 
{
    public function indexAction()
    {   

        $this->render('lote/index.php', [
                'head_js' => [ 'bower_components/angular-route/angular-route.min.js' ],
                'foot_js' => [ 'js/cadastros/lote.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }
}