<?php
namespace SiteControllers;

use Opis\Session\Session,
    \Financi\WebServices;

class HomeController extends \SlimController\SlimController 
{
    public function indexAction()
    {
        $this->render('home/index', []);
    }
}