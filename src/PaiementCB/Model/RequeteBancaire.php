<?php

namespace PaiementCB\Model;

class RequeteBancaire
{
    private $request;
    const PATH_BIN = "src/PaiementCB/Sherlocks/bin/static/request";
    const PATH_FILE = "src/PaiementCB/Sherlocks/param_demo/pathfile";

    public function __construct($prix, $emailCommande)
    {
        $idCommande = "0000001";

        $this->request = "merchant_id=014295303911111";
        $this->request = "$this->request merchant_country=fr";
        $this->request = "$this->request amount=" . $prix;

        $this->request = "$this->request pathfile=".$this::PATH_FILE;

        $this->request .= " customer_email=" . $emailCommande;

        $this->request .= " order_id=" . $idCommande;
    }

    public function execute(){

        
        $result=exec($this::PATH_BIN." $this->request");
        //echo($this::PATH_BIN." $this->request");
        $tableau = explode ("!", $result);
        //var_dump($tableau);
        $code = $tableau[1];
        $error = $tableau[2];
        $message = $tableau[3];

        if (( $code == "" )&&( $error == "" ) )
        {
            $txtReponse="executable request non trouve ".$this::PATH_BIN;
        }
        else if ($code != 0)
        {
            $txtReponse="<center><b><h2>Erreur appel API de paiement.</h2></center></b><br><br><br> message erreur : "
                .$error." <br>";
        }
        else
            {
            $txtReponse=($error!="")?"<br><br>".$error."<br />":"";
            $txtReponse.=$message;
        }

        return $txtReponse;
    }

}