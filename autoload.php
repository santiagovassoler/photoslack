<?php

spl_autoload_register(function($className) {

    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    var_dump($_SERVER['DOCUMENT_ROOT']);
    include_once $_SERVER['DOCUMENT_ROOT'] . '/app/code/PhotoSlack/' . $className . '.php';

});