<?php

namespace MP3\Controller;

use MP3\Model\AuthentificationAdapterInterface;
use MP3\Model\Request;
use MP3\Model\Response;
use MP3\View\View;
use MP3\Model\MP3StorageStub;


class MP3Controller
{
    protected $request;
    protected $response;
    protected $view;
    protected $authen;

    public function __construct(Request $request, Response $response, View $view,
                                AuthentificationAdapterInterface $authent)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->authen = $authent;


        $menu = array(
            "Accueil" => '?o=mp3&amp;a=makeHomePage'
        );
        $this->view->setPart('menu', $menu);

    }

    public function execute($action)
    {
        $this->$action();
    }

    public function toto() {
        $title = "Bienvenue !";
        $content = "Un site sur des poèmes.";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);

    }

    public function defaultAction()
    {
    }

    public function show() {
        // tester les en-têtes HTTP avec Response
        $this->response->addHeader('X-Debugging: show me a poem');

        $id = $this->request->getGetParam('id');

        $mp3Storage = new MP3StorageStub();
        $mp3 = $mp3Storage->read($id);

        if ($mp3 !== null) {
            /* Le poème existe, on prépare la page */
            $title = "« {$mp3->getTitle()} », par {$mp3->getArtist()}";

            $content = "<div class=\"mp3\">{$mp3->getTitle()}, par {$mp3->getArtist()}</div>\n";

            $this->view->setPart('title', $title);
            $this->view->setPart('content', $content);

        } else {
            $this->unknownPoem();
        }
    }

    public function connect(){

    }

    public function unknownPoem() {
        $title = "Poème inconnu ou non trouvé";
        $content = "Choisir un poème dans la liste.";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);
    }

    public function makeHomePage() {
        $mp3Storage = new MP3StorageStub();
        $mp3list = $mp3Storage->readAll();
        $this->view->setPart('title', 'TEST');
        $content ="";
        foreach( $mp3list as $key => $value){
            $content .=  "<a href='?o=mp3&amp;a=show&amp;id=". $value->getId() ."'>".$value->getTitle()."</a>\n";
        }
        $this->view->setPart('content', $content);
    }

}