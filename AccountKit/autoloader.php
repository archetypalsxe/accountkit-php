<?php

require_once("AccountKit/settings.php");

if(stripos($_SERVER['HTTP_HOST'], "localhost") !== FALSE || DEVELOP) {
    ini_set('display_errors', 1);
}

function __autoload($className) {
    $separator = DIRECTORY_SEPARATOR;

    $className = str_replace('\\', $separator, $className);
    $file = "{$className}.php";

    if(is_readable($file)) {
        require_once($file);
    }
}
