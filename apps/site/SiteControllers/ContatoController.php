<?php
namespace SiteControllers;

use Opis\Session\Session,
    \Financi\WebServices;

class ContatoController extends \SlimController\SlimController 
{
    public function indexAction()
    {
        $this->app->contentType('application/json');

        $data = json_decode($this->app->request->getBody());
        
        if($data->nome && $data->email && $data->telefone && $data->assunto) {

            $transport = \Swift_SmtpTransport::newInstance('fitcontas.com.br', 587, 'ssl')
                ->setUsername('fitcontas@fitcontas.com.br')
                ->setPassword('7efqmzmbn7');

            $mailer = \Swift_Mailer::newInstance($transport);

            $msg = '<p>' . $data->assunto .'</p><br/><br/><p>' . $data->nome . ' - ' . $data->telefone . '</p>';

            // Create a message
            $message = \Swift_Message::newInstance('Contato Site Village dos Lagos')
              ->setFrom(array($data->email => $data->nome))
              ->setTo(array('fernando@inova2b.com.br'))
              ->setBody($msg, 'text/html')
              ;

            // Send the message
            $result = $mailer->send($message);

            return $this->app->response->setBody(json_encode( ['success' => $result ] )); 
        }
    }
}