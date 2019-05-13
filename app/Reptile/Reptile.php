<?php

namespace App\Reptile;

use QL\QueryList;

/**
 * Class Reptile
 *
 * @package \App\Reptile
 */
class Reptile
{
    protected $html = null;

    public function boot($url)
    {
        $this->html = QueryList::get($url);
    }
    /**
     * 获取列表页链接
     * @param $url
     * @param $rule
     *
     * @return \App\Reptile\Array
     */
    public function listUrl($rule)
    {

        return $this->html->rules($rule)->queryData();
    }

    /**
     * 采集分页数量
     * @param $url
     * @param $rule
     *
     * @return \App\Reptile\Array
     */
    public function listPage($rule)
    {
        return $this->listUrl($url,['total' => $rule]);
    }

}
