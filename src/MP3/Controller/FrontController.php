<?php

namespace MP3\Controller;

use MP3\Model\AuthenticationManager;
use MP3\Model\AuthentificationAdapterInterface;
use MP3\View\View;
use MP3\Router\Router;
use MP3\Model\Request;
use MP3\Model\Response;

class FrontController
{
    protected $request;
    protected $response;

    public function __construct(Request $request,Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function execute()
    {
        $view = new View('template.php');
        try{
            $authent = new AuthenticationManager($this->request);
            $router = new Router($this->request);
            $className = $router->getControllerClassName();
            $action = $router->getControllerAction();

            $controller = new $className($this->request, $this->response, $view, $authent);
            $controller->execute($action);

             $idAuthen = $this->request->getPostParam('id', '');
            $mdpAuthen = $this->request->getPostParam('mdp', '');
            $content ='';
        } catch(Exception $e){
            $view->setPart('title', 'Erreur');
            $view->setPart('content', "Une erreur d'exécution s'est produite");
        }
        

       

        if( $this->request->getSession('login') == ''){
            if ( $idAuthen != '' && $mdpAuthen != ''){
                if ( !$authent->verifyAuth( $idAuthen, $mdpAuthen) ){

                    $content .="<div>Connexion impossible</div><br/>";
                    $content .= $authent->getForm();

                }
                else {
                    $content .="<div>Bonjour ". $this->request->getSession('nom')."</div>";
                }
            }else {
                $content .= $authent->getForm();
            }
        }
        else {
            $content .="<div>Bonjour ". $this->request->getSession('nom')."</div>";
        }

        $content .= $view->render();
        $this->response->send($content);
    }
}