<?php

namespace PaiementCB\Model;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class Mailer
{

    private $host;
    private $username;
    private $password;
    private $lien;

    public function __construct($lien)
    {
        $this->host = 'smtp.gmail.com';
        $this->username = 'smtp2140618421306107@gmail.com';
        $this->password = '1aez45gf865';
        $this->lien = $lien;
    }

    public function send_mail(){

        $transport = (new Swift_SmtpTransport($this->host, 587, 'tls'))
            ->setUsername($this->username)
            ->setPassword($this->password)
            ->setEncryption('tls');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Achat de mp3'))
            ->setFrom($this->username)
            ->setTo('slogi@live.com')
            ->setBody('Lien de téléchargement du fichier mp3'.$this->lien);

        try {
           echo $result = $mailer->send($message);
        }catch( \Swift_TransportException $e ){
            echo $e->getMessage();
        }
    }

}