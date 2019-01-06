<?php

namespace MP3\Model;

class Request
{
    private $get;
    private $post;
    private $files;
    private $server;
    private $session;

    public function __construct($get, $post, $files, $server, $session)
    {
        $this->get = $get;
        $this->post = $post;
        $this->files = $files;
        $this->server = $server;
        $this->session = $session;

    }

    public function getGetParam($key, $default = null)
    {
        if (!isset($this->get[$key])) {
            return $default;
        }
        return $this->get[$key];
    }

    public function getSession($key, $default = null)
    {
        if( !key_exists($key, $this->session)){
            return $default;
        }
        return $this->session[$key];
    }

    public function setSession($key, $value){
        $this->session[$key] = $value;
    }

    public function __destruct(){
        $_SESSION = $this->session;
    }

    public function setServer($key, $value){
        $this->server[$key] = $value;
    }

    public function getServerParam( $key, $default){
        if (!isset($this->server[$key])) {
            return $default;
        }
        return $this->server[$key];
    }

    public function getPostParam($key, $default = null)
    {
        if (!isset($this->post[$key])) {
            return $default;
        }
        return $this->post[$key];
    }

    public function getAllGetParams()
    {
        return $this->get;
    }

    public function getAllPostParams()
    {
        return $this->post;
    }

    public function getAllSessionParams()
    {
        return $this->session;
    }

}