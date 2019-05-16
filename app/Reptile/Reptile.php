<?php

namespace App\Reptile;

use App\Tools\Log;
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
        try{
            $this->html = QueryList::get($url);
        }catch (\Exception $exception){
            Log::boot()->error('reptile HTML error' . $url,[$exception->getMessage()]);
            return false;
        }

        return $this;
    }

    /**
     * 内容页链接
     * @param $rule
     *
     * @return array|bool
     */
    public function listUrl($rule)
    {

        $result = $this->html->rules(['link'=>explode('&&&',$rule)])->queryData();
        if(isset($result[0]['link']) && $result[0]['link'] != ''){

            return array_column($result,'link');
        }

        return false;
    }

    /**
     * 分页链接重组
     * @param \App\Reptile\string $url  链接 如：http://baidu.com/page/(*)
     * @param int|string                 $replace 需要替换的页码
     * @param string              $tag 替换标识
     *
     * @return mixed
     */
    public function urlFormat(string $url, $replace = null)
    {

        if($replace == null){
            return $url;
        }
        $rep_array = explode(',',$replace);

        $new_url = $this->pageFormat($url,$rep_array[0]);

        if(count($rep_array) == 2){
            $new_url = $this->sortFormat($new_url,$rep_array[1]);
        }
        return $new_url;
    }


    public function pageFormat(string $url, $replace = null,$tag = '(*)')
    {
        return str_replace($tag,$replace,$url);
    }

    public function sortFormat(string $url, $replace = null,$tag = '(#)')
    {
        return str_replace($tag,$replace,$url);
    }

    /**
     * 获取标题
     * @param $rule
     *
     * @return mixed
     */
    public function title($rule)
    {

        $result = $this->html->rules(['title'=>explode('&&&',$rule)])->queryData();

        if(isset($result[0]['title']) && $result[0]['title'] != ''){
            return $result[0]['title'];
        }
        return false;
    }

    /**
     *
     * @param $rule
     *
     * @return mixed
     */
    public function content($rule)
    {
        $result = $this->html->rules(['content'=>explode('&&&',$rule)])->queryData();

        if(isset($result[0]['content']) && $result[0]['content'] != ''){
            return $result[0]['content'];
        }
        return false;
    }

    /**
     *
     * @param $rule
     *
     * @return mixed
     */
    public function date($rule)
    {
        $result = $this->html->rules(['date'=>explode('&&&',$rule)])->queryData();

        if(isset($result[0]['date']) && $result[0]['date'] != ''){
            return $result[0]['date'];
        }
        return false;
    }

    /**
     *
     * @param $rule
     *
     * @return mixed
     */
    public function tag($rule)
    {

        $result = $this->html->rules(['tag'=>explode('&&&',$rule)])->queryData();
        if(isset($result[0]['tag']) && $result[0]['tag'] != ''){
            return array_column($result,'tag');
        }
        return false;
    }

}
