<?php

namespace App\Active;

use App\Models\Loc;
use App\Reptile\Reptile;
use App\Tools\Cache;
use App\Tools\Log;

/**
 * Class ReptileList
 *
 * @package \App\Active
 */
class ReptileList
{

    protected $reptile = null;
    protected $mysql = null;
    protected $log = null;
    protected $cache = null;

    public function __construct()
    {
        $this->reptile = new Reptile();
        $this->mysql = Loc::boot();
        $this->log = Log::boot();
        $this->cache = new Cache();
    }

    public function boot()
    {
        $web = $this->mysql->select('web','*',[
            'status' => 0
        ]);
        if(empty($web)){
            $this->log->info('web is empty');
            return false;
        }
        $this->start($web);
    }

    protected function start($web)
    {

        foreach ($web as $item){

            if($this->cache->get('web_id') != null && $this->cache->get('web_id') >= $item['id']){
                continue;
            }

            if(empty($item['list_total'])){
                $this->log->info('reptile list Link',[$item['link']]);
                $html_result = $this->reptile->boot($item['link']);
                if($html_result == false){
                    continue;
                }
                $result = $this->reptile->listUrl($item['list_rule']);
                if($result == false){
                    $this->log->error('reptile list rule error',[$item['link']]);
                    continue;
                }
                $this->addLink($result,$item['id']);
                $this->log->info('reptile list success',[$item['link']]);
            }else{
                $reptile_array = explode(',',$item['list_total']);
                $mark = count($reptile_array);

                $page = ($this->cache->get('web_list_id') != null) ? $this->cache->get('web_list_id') - 1 : $reptile_array[0];

                for ($i = $page; $i > 0; $i--){
                    $url = $this->urlFormat($item,$reptile_array,$mark,$i);
                    $this->log->info('reptile list Link',[$url]);

                    $html_result = $this->reptile->boot($url);
                    if($html_result == false){
                        continue;
                    }
                    $result = $this->reptile->listUrl($item['list_rule']);
                    if($result == false){
                        $this->log->error('reptile list rule error',[$url]);
                        continue;
                    }
                    $this->addLink($result,$item['id']);
                    $this->cache->put('web_list_id',$i);
                    $this->log->info('reptile list success',[$url]);
                }

            }
            $this->mysql->update('web',['status' => 1],['id'=>$item['id']]);
            $this->cache->put('web_id',$item['id']);
        }
        $this->cache->forget('web_id');
        $this->cache->forget('web_list_id');
        $this->log->info('reptile list All success');
    }


    protected function addLink($data,$id)
    {
        $result = array();
        if(is_array($data)){
            foreach ($data as $key=>$item){
                $result[$key]['link'] = $item;
                $result[$key]['web_id'] = $id;
            }
        }else{
            $result['link'] = $data;
            $result['web_id'] = $id;
        }

        if(empty($result)){
            return false;
        }

        $ret = $this->mysql->insert('links',$result);

    }

    /**
     * URL重组
     * @param array $item
     * @param       $reptile_array
     * @param       $mark
     * @param int   $default 默认页码
     *
     * @return mixed
     */
    protected function urlFormat(array $item,$reptile_array,$mark,$default = 1)
    {

        $url = $this->reptile->pageFormat($item['link'],$default);

        if($mark == 2){
            $url = $this->reptile->sortFormat($url,$reptile_array[1]);
        }

        return $url;
    }

}
