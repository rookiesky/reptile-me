<?php
include 'vendor/autoload.php';
include 'config/function.php';

define('DEBUG',true);
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");

Sentry\init(['dsn' => 'https://1327aabf127042ee838f4a4ebd8768ac@sentry.io/1461222' ]);


if(DEBUG == true){
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

