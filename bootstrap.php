<?php

//configurando o PHP para mostrar os erros na tela
ini_set('display_errors', 1);

//setando o timezone
date_default_timezone_set('America/Bahia');
 
//configurando o PHP para reportar todo e qualquer erro
error_reporting(E_ALL || E_STRICT);

define('ROOT', realpath(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT . DS . 'apps' . DS . 'financi');
define('APP_CONFIG_PATH', ROOT . DS . 'apps' . DS . 'financi' . DS . 'config');
define('HOST', 'http://' . $_SERVER['HTTP_HOST']);

require 'vendor/autoload.php';

Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding("UTF-8");
Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());


// Inciando o PHPActiveRecord
ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory(APP_PATH . DS . 'models');
    $cfg->set_connections(
        array(
           'development' => 'mysql://root:123@localhost/financi_dev',
           'test' => 'mysql://root:123@localhost/financi_dev',
           'production' => 'mysql://root:123@localhost/financi_dev'
        )
    );
    $cfg->set_default_connection('development');
});

ActiveRecord\DateTime::$DEFAULT_FORMAT = 'db';

// Iniando Slim Controller
$app = New \SlimController\Slim(array(
    'debug' => true,
    'mode' => 'development',
    'templates.path'             => APP_PATH . '/views',
    'controller.class_prefix'    => '\\Controllers',
    'controller.method_suffix'   => 'Action',
    'controller.template_suffix' => 'php',
    'view' => new \Financi\View(),
));

use Symfony\Component\Yaml\Yaml;

/*$usuario = new Usuario();
$usuario->usuario = 'nandodutra';
$usuario->email = 'fernando@inova2b.com.br';
$usuario->senha = sha1('123456');
$usuario->admin = true;
$usuario->save();*/

//Carrega um Array com as rotas do sistemas
$routes = Yaml::parse( APP_CONFIG_PATH . DS . 'routing.yml' );

//Percorre o array de rotas e adiciona as rotas ao slim
foreach($routes as $route) {
	$app->addRoutes([
			$route['url'] => [ $route['method'] => $route['route']]
		], function($route, $teste) use ($app) {
            if(!in_array($route->getName(), ['Home:login', 'Home:logar'], true)) {
                if(!\Financi\Auth::isAuth()) {
                    $app->redirect('/login');
                }
            } else {
                if(\Financi\Auth::isAuth()) {
                    $app->redirect('/');
                }
            }
    });
}

//Rodamos a aplicação
$app->run();