<?php
include 'vendor/autoload.php';

define('DEBUG',true);

if(DEBUG == true){
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

$controller = new \App\Controller\HomeController();

$controller->index();