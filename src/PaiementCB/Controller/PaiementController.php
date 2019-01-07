<?php
namespace PaiementCB\Controller;

use MP3\Model\Request;
use MP3\Model\Response;
use MP3\View\View;
use PaiementCB\Model\Mailer;
use PaiementCB\Model\ReponseBancaire;
use PaiementCB\Model\RequeteBancaire;
use MP3\Model\AuthentificationAdapterInterface;


class PaiementController
{
    protected $request;
    protected $response;
    protected $view;
    protected $authen;

    public function __construct(Request $request, Response $response, View $view, AuthentificationAdapterInterface $authent)
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

    public function requete(){

        $prix = $this->request->getPostParam('prix', '');
        $email = $this->request->getPostParam('email', '');
        $nameFile = $this->request->getPostParam('nameFile', '');

        $requete = new RequeteBancaire($prix, $email, $nameFile);

        $content = $requete->execute();
        $this->view->setPart('content', $content);
    }

    public function reponseAccepte (){
        if ( $this->request->getPostParam('DATA', '')){
            $reponse = new ReponseBancaire($this->request->getPostParam('DATA', ''));
            $tableau = $reponse->analyseRequete($this->request->getPostParam('DATA', ''));
            $result = $reponse->paiementAccepte($tableau);
            /*$this->response->addHeader('Content-type: audio/mpeg');
            $this->response->addHeader('Content-Disposition: attachment; filename="'.$result[28].'.mp3');
            readfile("sons/".$result[28].".mp3");
            exit();*/
            $titre = "<h1>Paiement Accepté</h1>";
            $content = "<p>Votre paiement n°".$result[6]." a été accepté, la connexion a smtp.gmail.com ne fonctionnant pas, le son n'est pas disponible.</p>";
            $this->view->setPart('title', $titre);
            $this->view->setPart('content', $content);
        } else {
            $this->response->addHeader("Location : ?o=mp3Controller&a=makeHomePage");
        }
    }

    public function reponseRefus (){
        if ( $this->request->getPostParam('DATA', '')) {
            $reponse = new ReponseBancaire($this->request->getPostParam('DATA', ''));
            $tableau = $reponse->analyseRequete($this->request->getPostParam('DATA', ''));
            $result = $reponse->paiementRefuse($tableau);
            $titre = "<h1>Paiement Refusé</h1>";
            $content = "<p>Votre paiement n°".$result[6]." n'a pas été accepté, veuillez vous référer à votre banque ou réessayer plus tard.</p>";
            $this->view->setPart('title', $titre);
            $this->view->setPart('content', $content);
        } else {
            $this->response->addHeader("Location : ?o=mp3Controller&a=makeHomePage");
        }
    }

    public function consulterLogs(){
        $title = "Consultation des logs d'achat d'un mp3";
        $this->view->setPart('title', $title);


        $file = fopen(ReponseBancaire::PATH_LOG_ACCEPTE, "r");
        $content ="<div class='logs'>";
        $content .= "<div class='logsAccept'>";
        $content .= "<h3>Logs des paiements Acceptés</h3>";
        while(!feof($file))
        {
            $content .= "<p>".fgets($file). "</p>";
        }
        fclose($file);
        $content .= "</div>";

        $file = fopen(ReponseBancaire::PATH_LOG_REFUSE, "r");
        $content .= "<div class='logsRefuse'>";
        $content .= "<h3>Logs des paiements refusés</h3>";
        while(!feof($file))
        {
            $content .= "<p>".fgets($file). "</p>";
        }
        fclose($file);
        $content .= "</div>";
        $content .= "</div>";

        $this->view->setPart('content', $content);

    }

    public function erreur(){
        $title = "Page Inconnu - 404 erreur";
        $content = "La page que vous avez demandé n'existe pas.";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);

    }

    /*public function download()
    {
        if ($this->request->getGetParam('code') == $this->codeDl) {
            $this->response->addHeader("Content-Disposition: attachment; filename=\"" . basename('sons/'.$this->id) . "\"");
            $this->response->addHeader("Content-Type: application/force-download");
            $this->response->addHeader("Content-Length: " . filesize('sons/'.$this->id));
            $this->response->addHeader("Connection: close");
        } else {
            $this->response->addHeader("Location : ?o=mp3Controller&a=makeHomePage");
        }

    }*/
}