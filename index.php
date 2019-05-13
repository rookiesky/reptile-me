<?php
include 'vendor/autoload.php';

define('DEBUG',true);
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");

if(DEBUG == true){
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

$controller = new \App\Controller\HomeController();



if(isset($_GET['type'])){

    switch ($_GET['type']){
        case 'add':
            $controller->create();
            break;
        case 'test-list':
            $controller->testList();
            break;
        case 'test-page':
            $controller->testPage();
            break;
    }

}else{
    $controller->index();
}
