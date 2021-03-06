<?php


namespace MP3\Model;


class AuthenticationManager implements AuthentificationAdapterInterface
{
    private $users = array(
        'jml' => array(
            'id' => 12,
            'nom' => 'Lecarpentier',
            'prenom' => 'Jean-Marc',
            'mdp' => 'toto',
            'statut' => 'admin'
        ),
        'alex' => array(
            'id' => 5,
            'nom' => 'Niveau',
            'prenom' => 'Alexandre',
            'mdp' => 'toto',
            'statut' => 'admin'
        )
    );

    private $login;
    private $id;
    private $nom;
    private $prenom;
    private $statut;
    private $request;
    private $form;
    private $response;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->form = "<form class='formId' name='connexion' action='".$this->request->getServerParam('REQUEST_URI', '?o=mp3&a=makeHomePage')."' method='POST'>";
        $this->form .= "<label>Identifiant</label><input name='id' type='text' /><br />";
        $this->form .= "<label>Pwd</label><input name='mdp' type='password' /><br />";
        $this->form .= "<input class='btnId' type='submit' value='Valider'>";
        $this->form .= "</form>";

        if ($request->getSession('login')) {
            $this->login = $request->getSession('login');
            $this->id = $request->getSession('id');
            $this->nom = $request->getSession('nom');
            $this->prenom = $request->getSession('prenom');
            $this->statut = $request->getSession('statut');
        }
        else {
            $this->login = null;
            $this->id = null;
            $this->nom = null;
            $this->prenom = null;
            $this->statut = null;
        }
    }

    public function verifyAuth( $login, $mdp )
    {
        foreach ( $this->users as $key => $value ){
            if ($key == $login ) {
                if ($value['mdp'] == $mdp ) {
                    $this->request->setSession('login', $key);
                    $this->request->setSession('id', $value['id']);
                    $this->request->setSession('nom', $value['nom']);
                    $this->request->setSession('prenom', $value['prenom']);
                    $this->request->setSession('statut', $value['statut']);
                }
            }
        }
        return false;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function disconnect()
    {
        session_destroy();
    }

}
