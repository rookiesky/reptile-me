<?php

namespace App\Active;

use App\Article\TypechoArticle;
use App\Models\Loc;
use App\Reptile\Reptile;
use App\Tools\Cache;
use App\Tools\Log;

/**
 * Class ReptileContent
 *
 * @package \App\Active
 */
class ReptileContent
{
    protected $log = null;
    protected $cache = null;
    protected $mysql = null;
    protected $reptile = null;

    public function __construct()
    {
        $this->log = Log::boot();
        $this->cache = new Cache();
        $this->mysql = Loc::boot();
        $this->reptile = new Reptile();
    }

    public function start()
    {
        $links = $this->mysql->select('links','*',[
            'status' => 0,
            'LIMIT' => 2
        ]);
        $this->mysql->update('links',['status'=>1],[
            'id' => array_column($links,'id')
        ]);

        $result = array();
        foreach ($links as $key=>$item){
            $web = $this->getWeb($item['web_id']);
            if($web == false){
                $this->log->error('reptile link error,web is empty',[$item['link']]);
                continue;
            }

            $html_reptile = $this->reptile->boot($item['link']);
            if($html_reptile == false){
                continue;
            }

            $result['title'] = $this->reptile->title($web['content_title']);
            if(empty($result['title'])){
                $this->log->error('reptile article title empty',[$item['link']]);
                continue;
            }
            $result['content'] = $this->reptile->title($web['content']);

            if(empty($result['content'])){
                $this->log->error('reptile article content empty',[$item['link']]);
                continue;
            }
            $result['date'] = $this->reptile->title($web['content_date']);

            $result['tag'] = $this->reptile->title($web['content_tag']);

            if($web['ruku_type'] == 'typecho'){
                $ret = (new TypechoArticle())->put($result,$web);
            }

            if($ret){
                $this->mysql->delete('links',[
                    'id' => $item['id'],
                ]);
            }

        }


    }



    protected function getWeb($web_id)
    {
        $web = $this->cache->get('web_links_' . $web_id);
        if( $web != null){
            return $web;
        }
        $web = $this->mysql->get('web','*',[
            'id' => $web_id
        ]);
        if(empty($web)){
            return false;
        }
        $this->cache->put('web_links_'.$web['id'],$web);
        return $web;
    }

}
