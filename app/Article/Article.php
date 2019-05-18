<?php

namespace App\Article;

use Medoo\Medoo;

/**
 * Class Article
 *
 * @package \App\Article
 */
class Article
{
    protected static function mysql($config)
    {
        return new Medoo([
            'database_type' => 'mysql',
            'database_name' => $config['mysql_table'],
            'server' => $config['mysql_host'],
            'username' => $config['mysql_user'],
            'password' => $config['mysql_password'],

            // [optional]
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'port' => $config['mysql_prot'],
            'prefix' => $config['mysql_prefix'],
        ]);
    }

    /**
     * 匹配分类
     * @param $ruku_id
     * @param $tag
     *
     * @return false|int|string
     */
    protected function sort($ruku_id,$tag)
    {
        $ruku_id_array = explode(',',$ruku_id);

        if(count($ruku_id_array) == 1){
            return $ruku_id_array[0];
        }
        if(is_string($tag)){
            return array_search($tag,$ruku_id_array);
        }

        foreach ($tag as $item){
            $id = array_search($item,$ruku_id_array);
            if($id){
                return $id;
            }
        }
        return false;
    }
}
