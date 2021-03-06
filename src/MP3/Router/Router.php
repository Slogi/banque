<?php

namespace MP3\Router;

use MP3\Model\Request;

class Router
{
    protected $controllerClassName;
    protected $controllerAction;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->parseRequest();
    }

    public function getControllerClassName()
    {
        return $this->controllerClassName;
    }

    public function getControllerAction()
    {
        return $this->controllerAction;
    }

    protected function parseRequest()
    {
        $package = $this->request->getGetParam('o');

        switch ($package) {
        case 'mp3':
            $this->controllerClassName = 'MP3\Controller\MP3Controller';
            break;
        case 'paiement':
            $this->controllerClassName = 'PaiementCB\Controller\PaiementController';
            break;
        default:
            $this->controllerClassName = 'MP3\Controller\MP3Controller';
        }

        if (!class_exists($this->controllerClassName)) {
            throw new \Exception("Classe {$this->controllerClassName} non existante");
        }
        $this->controllerAction = $this->request->getGetParam('a', 'makeHomePage');

        if (!method_exists($this->controllerClassName, $this->request->getGetParam('a')) && $this->request->getGetParam('a') != '') {
            $this->controllerAction ="erreur";
        }

    }

}
