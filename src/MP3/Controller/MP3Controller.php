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
            "Accueil" => '?o=mp3&amp;a=makeHomePage',
            "MP3 numero 1" => '?o=mp3&amp;a=show&amp;id=01',
            "Gérer les MP3" => '?o=mp3&amp;a=mp3List'
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

    public function mp3List(){
        $mp3Storage = new MP3StorageStub();
        $mp3list = $mp3Storage->readAll();
        $this->view->setPart('title', 'TEST');
        $content ="";
        foreach( $mp3list as $key => $value){
            $content .= $value->getTitle()."\n";
        }
        $this->view->setPart('content', $content);

    }

    public function show() {
        // tester les en-têtes HTTP avec Response
        $this->response->addHeader('X-Debugging: show me a poem');

        $id = $this->request->getGetParam('id');

        $poemStorage = new MP3StorageStub();
        $poem = $poemStorage->read($id);

        if ($poem !== null) {
            /* Le poème existe, on prépare la page */
            $image = "images/{$poem->getImage()}";
            $title = "« {$poem->getTitle()} », par {$poem->getAuthor()}";
            $content = "<figure>\n<img src=\"$image\" alt=\"{$poem->getAuthor()}\" />\n";
            $content .= "<figcaption>{$poem->getAuthor()}</figcaption>\n</figure>\n";
            $content .= "<div class=\"poem\">{$poem->getText()}</div>\n";

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
        $title = "Bienvenue !";
        $content = "Un site sur des poèmes.";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);
    }

}