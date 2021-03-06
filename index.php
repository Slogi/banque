<?php
session_name("banqueMP3");
session_start();
require('vendor/autoload.php');
require('config/autoload.php');

$request = new \MP3\Model\Request($_GET, $_POST, $_FILES, $_SERVER, $_SESSION);
$response = new \MP3\Model\Response();
$router = new \MP3\Controller\FrontController($request, $response);
$router->execute();