<?php
include 'vendor/autoload.php';
include 'config/function.php';

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
        case 'test-title':
            $controller->testTitle();
            break;
        case 'test-content':
            $controller->testContent();
            break;
        case 'test-date':
            $controller->testDate();
            break;
        case 'test-tag':
            $controller->testTag();
            break;
        case 'create':
            $controller->store();
            break;
    }

}else{
    $controller->index();
}
