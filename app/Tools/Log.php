<?php

namespace App\Tools;

use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Log
 *
 * @package \App\Tools
 */
class Log
{
    public static function boot()
    {
        $logger = new Logger('reptile_me');
        $file = BASE_PATH . '/store/log/' . date('Y-m-d') . '.log';
        $logger->pushHandler(new StreamHandler($file),Logger::DEBUG);
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }
}
