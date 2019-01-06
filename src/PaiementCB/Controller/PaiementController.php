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
        $this->id = $this->request->getPostParam('id','');

        $requete = new RequeteBancaire($prix, $email);

        $content = $requete->execute();
        $this->view->setPart('content', $content);
    }

    public function reponseAccepte (){
        if ( $this->request->getPostParam('DATA', '')){
            $reponse = new ReponseBancaire($this->request->getPostParam('DATA', ''));
            $tableau = $reponse->analyseRequete($this->request->getPostParam('DATA', ''));
            $result = $reponse->paiementAccepte($tableau);
            /*$codeDl = rand(10, 5000);
            $mailer = new Mailer("https://dev-21406184.users.info.unicaen.fr/devoir-idc2018/?o=paiement&a=download&code=".$codeDl);
            $mailer->send_mail();*/

        } else {
            $this->response->addHeader("Location : ?o=mp3Controller&a=makeHomePage");
        }
    }

    public function reponseRefus (){
        if ( $this->request->getPostParam('DATA', '')) {
            $reponse = new ReponseBancaire($this->request->getPostParam('DATA', ''));
            $tableau = $reponse->analyseRequete($this->request->getPostParam('DATA', ''));
            $result = $reponse->paiementRefuse($tableau);
            $this->view->setPart('content', print_r($result));
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
        while(!feof($file))
        {
            $content .= "<p>".fgets($file). "</p>";
        }
        fclose($file);
        $content .= "</div>";

        $file = fopen(ReponseBancaire::PATH_LOG_REFUSE, "r");
        $content .= "<div>";
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