<?php
namespace PaiementCB\Controller;

use MP3\Model\Request;
use MP3\Model\Response;
use MP3\View\View;
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

    public function cancel(){

        if ( $this->request->getPostParam('DATA', '') != null ){
            $reponse = new ReponseBancaire($_POST['DATA']);
            $tableau = $reponse->cancel();
            var_dump($tableau);
            $content = "Votre paiement de " . $tableau[5] . " a été refusé";
            $this->view->setPart('content', $content);
        }

    }

    public function confirmation(){
        if ( $this->request->getPostParam('DATA', '') != null ){
            $reponse = new ReponseBancaire($_POST['DATA']);
            $tableau = $reponse->confirmation();
            var_dump($tableau);
            $content = "Votre paiement de " . $tableau[5] . " a été accepté";
            $this->view->setPart('content', $content);
        }
    }


}