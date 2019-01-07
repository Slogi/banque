<?php

namespace MP3\View;

class View
{
    protected $parts;
    protected $template;

    public function __construct($template, $parts = array())
    {
        $this->template = $template;
        $this->parts = $parts;
    }

    public function setPart($key, $content)
    {
        $this->parts[$key] = $content;
    }

    public function getPart($key)
    {
        if (isset($this->parts[$key])) {
            return $this->parts[$key];
        } else {
            return null;
        }
    }

    public function render()
    {
        $title = $this->getPart('title');
        $content = $this->getPart('content');
        $form = $this->getPart('form');
        $menu = $this->getPart('menu');
        $meta = $this->getPart('meta');
        $player = $this->getPart('player');
        $formBuy = $this->getPart('formBuy');
        $formModif = $this->getPart('formModif');


        ob_start();
        include($this->template);
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }


}