<?php

namespace Financi;

use Opis\Session\Session;

class Empreendimento extends \SlimController\SlimController
{
    public function indexAction()
    {
        $this->render('empreendimento/index.php', [
                'foot_js' => [ 'js/empreendimento/usuario.js', 'bower_components/lodash/dist/lodash.min.js']
            ]);
    }
}