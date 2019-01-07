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

            if($this->request->getSession('login') == '') {
                if ($idAuthen != '' && $mdpAuthen != '') {
                    if (!$authent->verifyAuth($idAuthen, $mdpAuthen) ) {
                        $content .= "<div class='formId'>";
                        $content .="<div>Connexion impossible</div><br/>";
                        $content .= $authent->getForm();
                        $content .= "</div>";

                        $menu = array(
                            "Accueil" => '?o=mp3&amp;a=makeHomePage'
                        );
                        $view->setPart('menu', $menu);
                    }
                    else {
                        $content .= "<div class='formId'>";
                        $content .="<div>Bonjour ". $this->request->getSession('nom')."</div>";
                        $content .="<a href='?o=mp3&amp;a=logout'>Deconnexion</a>";
                        $content .= "</div>";
                        $menu = array(
                            "Accueil" => '?o=mp3&amp;a=makeHomePage',
                            "Binome" => '?o=mp3&amp;a=binome',
                            "Consulter les logs" => '?o=paiement&amp;a=consulterLogs'
                        );
                        $view->setPart('menu', $menu);
                    }
                }else {
                    $content .= "<div class='formId'>";
                    $content .= $authent->getForm();
                    $content .= "</div>";
                    $menu = array(
                        "Accueil" => '?o=mp3&amp;a=makeHomePage',
                        "Binome" => '?o=mp3&amp;a=binome'
                    );
                    $view->setPart('menu', $menu);
                }
            }
            else {
                $content .= "<div class='formId'>";
                $content .="<div>Bonjour ". $this->request->getSession('nom')."</div>";
                $content .="<a href='?o=mp3&amp;a=logout'>Deconnexion</a>";
                $content .= "</div>";
                $menu = array(
                    "Accueil" => '?o=mp3&amp;a=makeHomePage',
                    "Binome" => '?o=mp3&amp;a=binome',
                    "Consulter les logs" => '?o=paiement&amp;a=consulterLogs'
                );
                $view->setPart('menu', $menu);
            }
            $view->setPart('form', $content);
        } catch(Exception $e){
            $view->setPart('title', 'Erreur');
            $view->setPart('content', "Une erreur d'exécution s'est produite");
        }

        $this->response->send($view->render());
    }
}
