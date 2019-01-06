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
    protected $codeDl;

    public function __construct(Request $request, Response $response, View $view, AuthentificationAdapterInterface $authent)
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

    public function requete(){

        $prix = $this->request->getPostParam('prix', '');
        $email = $this->request->getPostParam('email', '');

        $requete = new RequeteBancaire($prix, $email);

        $content = $requete->execute();
        $this->view->setPart('content', $content);
    }

    public function reponseAccepte (){
        if ( $this->request->getPostParam('DATA', '')){
            $reponse = new ReponseBancaire($this->request->getPostParam('DATA', ''));
            $tableau = $reponse->analyseRequete($this->request->getPostParam('DATA', ''));
            $result = $reponse->paiementAccepte($tableau);
            $this->view->setPart('content', "<a href='?o=paiement&amp;a=envoieMail'>ENVOIE MAIL</a>");

        }
    }

    public function reponseRefus (){
        if ( $this->request->getPostParam('DATA', '')) {
            $reponse = new ReponseBancaire($this->request->getPostParam('DATA', ''));
            $tableau = $reponse->analyseRequete($this->request->getPostParam('DATA', ''));
            $result = $reponse->paiementRefuse($tableau);
            $this->view->setPart('content', print_r($result));
        }
    }

    public function envoieMail(){
        $mailer = new Mailer();
        echo $mailer->send_mail();

    }

    public function download(){

    }


}