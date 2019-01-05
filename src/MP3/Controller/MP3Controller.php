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
            //"Accueil" => ''
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
           /* $ogTitle = "";
            $ogType = "music";
            $ogUrl = "https://dev-21306107.users.info.unicaen.fr/devoir-idc2018/?o=mp3&a=show&id={$mp3->getId()}";
            $ogImage = "";*/

            $ogTitle = "Page de détail du son {$mp3->getTitle()}";
            $ogUrl = "https://dev-21306107.users.info.unicaen.fr/devoir-idc2018/?o=mp3&a=show&id={$mp3->getId()}";
            $title = "« {$mp3->getTitle()} », par {$mp3->getArtist()}";

            $content = "<div class=\"mp3\" itemscope itemtype=\"https://schema.org/MusicRecording\">";
            $content .= "<p><span itemprop='name'>{$mp3->getTitle()}</span>, par <span itemprop='byArtist'>{$mp3->getArtist()}</span>.</p>";
            $content .= "<p>Date : <span itemprop='dateCreated'>{$mp3->getDate()}</span></p>";
            $content .= "<p>Album : <span itemprop='inAlbum'>{$mp3->getAlbum()}</span></p>";
            $content .= "<p>Durée : <span itemprop='duration'>{$mp3->getDuree()}</span></p>";
            $content .= "<p>Type mime : <span  itemprop='encodingFormat'>{$mp3->getMimeType()}</span></p>";
            $content .= "<p>Format : {$mp3->getDataFormat()}</p>";
            $content .= "<p>Channel : {$mp3->getChannelMode()}</p>";
            $content .= "<p>Copyright : <span itemprop='copyrightHolder'>{$mp3->getCopyright()}</span></p>"; //TODO CLASSE COPYRIGHT GRAS
            $content .= "</div>\n";


            //$this->view->setPart('ogTitle', $ogTitle);
            //$this->view->setPart('ogType', $ogType);
            //$this->view->setPart('ogUrl', $ogUrl);
            //$this->view->setPart('ogImage', $ogImage);
            $this->view->setPart('title', $title);
            $this->view->setPart('content', $content);
            $this->view->setPart('ogTitle', $ogTitle);
            $this->view->setPart('ogUrl', $ogUrl);


        } else {
            $this->unknownPoem();
        }
    }

    public function logout(){
        $this->authen->disconnect();
        header('Location: ?o=mp3&a=makeHomePage');//TODO essayer de se servir de response addHeaders()

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
        $content .= "<ul>";
        foreach( $mp3list as $key => $value){
            $content .= "<li>";
            $content .=  "<a href='?o=mp3&amp;a=show&amp;id=". $value->getId() ."'>".$value->getTitle()."</a>";
            $content .= "</li>";
        }
        $content .= "</ul>";
        $ogTitle = "Page d'accueil";
        $ogUrl = "https://dev-21306107.users.info.unicaen.fr/devoir-idc2018/?o=mp3&a=makeHomePage";
        $this->view->setPart('content', $content);
        $this->view->setPart('ogTitle', $ogTitle);
        $this->view->setPart('ogUrl', $ogUrl);

    }

}