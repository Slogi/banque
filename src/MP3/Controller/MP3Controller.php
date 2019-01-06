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
    protected $accessManager;

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
            $ogTitle = 'Page de détail du son "'.$mp3->getTitle().'"';
            $ogUrl = "https://dev-21306107.users.info.unicaen.fr/devoir-idc2018/?o=mp3&a=show&id={$mp3->getId()}";
            $meta = "<meta property=\"og:title\" content=".$ogTitle."/>";
            $meta .= "<meta property=\"og:type\" content=\"music\" />";
            $meta .= "<meta property=\"og:url\" content=".$ogUrl." />";
            $meta .= "<meta property=\"og:image\" content= />";
            $meta .= "<meta name=”twitter:card” content=”summary” />";
            $meta .= "<meta name=”twitter:site” content=$ogUrl />";
            $meta .= "<meta name=”twitter:title” content=$ogTitle />";
            $meta .= "<meta name=”twitter:description” content=”” />";
            $meta .= "<meta name=”twitter:image” content=”” />";

            $title = "« {$mp3->getTitle()} », par {$mp3->getArtist()}";

            $player = "<audio controls controlsList='nodownload'>";
            $player .= "<source src='{$mp3->getPath()}' type=\"audio/ogg\">";
            $player .= "<source src='{$mp3->getPath()}' type=\"audio/mpeg\">";
            $player .= "Your browser does not support the audio element.";
            $player .= "</audio>";

            $content = "<div class=\"mp3\" itemscope itemtype=\"https://schema.org/MusicRecording\">";
            $content .= "<p><span itemprop='name'>{$mp3->getTitle()}</span>, par <span itemprop='byArtist'>{$mp3->getArtist()}</span>.</p>";
            $content .= "<p>Date : <span itemprop='dateCreated'>{$mp3->getDate()}</span></p>";
            $content .= "<p>Album : <span itemprop='inAlbum'>{$mp3->getAlbum()}</span></p>";
            $content .= "<p>Durée : <span itemprop='duration'>{$mp3->getDuree()}</span></p>";
            $content .= "<p>Type mime : <span  itemprop='encodingFormat'>{$mp3->getMimeType()}</span></p>";
            $content .= "<p>Format : {$mp3->getDataFormat()}</p>";
            $content .= "<p>Channel : {$mp3->getChannelMode()}</p>";
            $content .= "<p class='copyright'>Copyright : <span itemprop='copyrightHolder'>{$mp3->getCopyright()}</span></p>"; //TODO CLASSE COPYRIGHT GRAS
            $content .= "</div>\n";

            $formBuy = "<form class='formBuy' action='?o=paiement&amp;a=requete' method='POST'>";
            $formBuy .= "<input type='hidden' name='prix' value='500'>";
            $formBuy .= "<input type='email' id='email' pattern='.+@.+' size='30' required placeholder='Votre addresse e-mail'>";
            $formBuy .= "<input class='btnBuy' type='submit' value='Acheter'>";
            $formBuy .= "</form>";

            // CONNEXION
            $formModif = "<form class='formModif' action='?o=mp3&amp;a=traitement&id={$mp3->getId()}' method='POST'>";
            $formModif .= "<label>Titre</label><input type='text'  name='titre' size='80' value='{$mp3->getTitle()}'/><br />";
            $formModif .= "<label>Artiste</label><input type='text'  name='artiste' size='20' value='{$mp3->getArtist()}'/><br />";
            $formModif .= "<label>Album</label><input type='text'  name='album' size='80' value='{$mp3->getAlbum()}'/><br />";
            $formModif .= "<label>Copyright</label><input type='text'  name='copyright' size='20' value='{$mp3->getCopyright()}'/><br />";
            $formModif .= "<input class='btnModif' type='submit' value='Modifier'/>";
            // CONNEXION

            $this->view->setPart('title', $title);
            $this->view->setPart('content', $content);
            $this->view->setPart('meta', $meta);
            $this->view->setPart('player', $player);
            $this->view->setPart('formBuy', $formBuy);

            // CONNEXION
            $this->view->setPart('formModif', $formModif);
            // CONNEXION

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
        $content = "<div class='mp3'>Choisir un poème dans la liste.</div>";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);
    }

    public function makeHomePage() {
        $mp3Storage = new MP3StorageStub();
        $mp3list = $mp3Storage->readAll();

        $content ="";
        $content .= "<ul>";
        foreach( $mp3list as $key => $value){
            $content .= "<li>";
            $content .=  "<div style='overflow: hidden; padding-right: .5em;'><a href='?o=mp3&amp;a=show&amp;id=". $value->getId() ."'>".$value->getTitle()."  </a></div>";
            // CONNEXION
            $content .= "<form action='?o=mp3&amp;a=supprimer&id={$value->getId()}' method='POST'>";
            $content .= "<input class='btnSuppr' type='submit' id='suppr{$value->getId()}' name='suppr' value='Supprimer'>";
            $content .= "</form>";
            // CONNEXION
            $content .= "</li></br>";
        }
        $content .= "</ul>";
        $this->view->setPart('title', 'Liste des sons mp3');
        $this->view->setPart('content', $content);
    }

    public function traitement(){
        if($this->request->getPostParam('titre') != null){
            $id = $this->request->getGetParam('id');
            $mp3Storage = new MP3StorageStub();
            $mp3 = $mp3Storage->read($id);
            $path = $mp3->getPath();
            //echo("path : ".$path);

            $title = $this->request->getPostParam('titre');
            $artist = $this->request->getPostParam('artiste');
            $album = $this->request->getPostParam('album');
            $copyright = $this->request->getPostParam('copyright');


            exec("ffmpeg -i ".$path." -c copy -metadata title='".$title."'  sons/test.mp3" );
            unlink($path);
            rename( 'sons/test.mp3', $path);

            exec("ffmpeg -i ".$path." -c copy -metadata artist='".$artist."'  sons/test.mp3" );
            unlink($path);
            rename( 'sons/test.mp3', $path);

            exec("ffmpeg -i ".$path." -c copy -metadata album='".$album."'  sons/test.mp3" );
            unlink($path);
            rename( 'sons/test.mp3', $path);

            exec("ffmpeg -i ".$path." -c copy -metadata copyright='".$copyright."'  sons/test.mp3" );
            unlink($path);
            rename( 'sons/test.mp3', $path);




            //echo("ffmpeg -i ".$path." -metadata title='".$title."' ".$path);
            //header('Location: ?o=mp3&a=show&id='.$id);
            //TODO REDIRECTION
            $mp3Storage = new MP3StorageStub();
            $mp3 = $mp3Storage->read($id);
        }
    }

    public function supprimer(){
        if($this->request->getPostParam('suppr') != null){
            $id = $this->request->getGetParam('id');
            $mp3Storage = new MP3StorageStub();
            $mp3 = $mp3Storage->read($id);
            $path = $mp3->getPath();
            unlink($path);
            //TODO REDIRECTION
        }
    }

}