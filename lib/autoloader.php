<?php

require_once("lib/settings.php");

if(stripos($_SERVER['HTTP_HOST'], "localhost") !== FALSE || DEVELOP) {
    ini_set('display_errors', 1);
}

function __autoload($className) {
    $separator = DIRECTORY_SEPARATOR;
    $dir = __DIR__;

    $className = str_replace('\\', $separator, $className);
    $file = "{$dir}{$separator}{$className}.php";

    if(is_readable($file)) {
        require_once($file);
    }
}
