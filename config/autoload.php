<?php

function autoloader($class)
{
    include 'src\\'.$class.'.php';
}

spl_autoload_register('autoloader');