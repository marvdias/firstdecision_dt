<?php

spl_autoload_register(function($classname){

    $fullpath = str_replace('MarcusDias\\FirstDecisionDT', 'app', $classname);
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $fullpath).'.php';
    if (file_exists($filename)) {
        require_once $filename;
    } else {
        echo $fullpath."<br>\n";
        echo $filename."<br>\n";
    }
});