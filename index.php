<?php
include_once 'init.php';

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
        case 'list':
            $controller->listView();
            break;
        case 'edit':
            $controller->show();
            break;
        case 'update':
            $controller->update();
            break;
        case 'delete':
            $controller->destroy();
            break;
    }

}else{
    $controller->index();
}
