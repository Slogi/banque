<?php
/**
 * Created by PhpStorm.
 * User: Slogix
 * Date: 18/09/2018
 * Time: 10:15
 */

namespace MP3\Model;


interface AuthentificationAdapterInterface
{
    public function verifyAuth( $login, $mdp );
    public function getForm();
    public function disconnect();

}
