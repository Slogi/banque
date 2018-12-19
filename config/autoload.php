<?php

function autoloader($class)
{
    $className = str_replace((DIRECTORY_SEPARATOR == '/' ? '\\' : '/'), DIRECTORY_SEPARATOR, $class);
    include 'src/'.$className.'.php';
}

spl_autoload_register('autoloader');

