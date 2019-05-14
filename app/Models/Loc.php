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
        $data = include BASE_PATH . 'config.inc.php';
        return new Medoo($data);
    }
}
