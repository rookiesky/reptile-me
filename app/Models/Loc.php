<?php

namespace App\Models;

use Medoo\Medoo;

/**
 * Class Loc
 *
 * @package \App\Models
 */
class Loc
{
    public static function boot()
    {
        $config = include_once (BASE_PATH . 'config.inc.php');
        return new Medoo($config);
    }
}
