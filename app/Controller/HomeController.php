<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Date: 2019-05-12
 * Time: 17:15
 */

namespace App\Controller;

use App\Active\ReptileContent;
use App\Models\Loc;
use App\Reptile\Reptile;


class HomeController extends Controller
{
    public function index()
    {
        $content = new ReptileContent();
        $content->start();
        include BASE_PATH . 'view/index.html';
    }

    public function create()
    {
        include BASE_PATH . 'view/create.html';
    }

    public function store()
    {
        $data = $_POST;
        try{
            Loc::boot()->insert('web',$data);
            return $this->response(null,'增加成功');
        }catch (\Exception $exception){
            return $this->response(null,'提交失败',500);
        }
    }
    
    /**
     * 测试列表采集规则
     */
    public function testList()
    {
        $url = $_POST['url'];
        $rule = $_POST['rule'];
        $page_rule = $_POST['page'];
        if(empty($url) || empty($rule) || empty($page_rule)){
            $this->response(null,'链接或规则不能为空',404);
        }
        $data = $this->getList($url,$rule,$page_rule);

        if($data != false){
            return $this->response($data);
        }
        return $this->response(null,'采集失败',403);
    }


    protected function getList($url,$rule,$page_rule)
    {
        $reptile = new Reptile();

        $url = $reptile->urlFormat($url,$page_rule);

        return $reptile->boot($url)->listUrl($rule);
    }

    public function testTitle()
    {
        $url = $_POST['url'];
        $rule = $_POST['rule'];
        $page_rule = $_POST['page'];
        $title_rule = $_POST['title'];
        if(empty($url) || empty($rule) || empty($title_rule)){
            $this->response(null,'链接或规则不能为空',404);
        }

        $list = $this->getList($url,$rule,$page_rule);

        if($list == false){
            return $this->response(null,'列表采集失败',403);
        }

        $title = (new Reptile())->boot($list[0])->title($title_rule);
        if($title != false){
            return $this->response($title);
        }
        return $this->response(null,'采集失败',403);
    }

    public function testContent()
    {
        $url = $_POST['url'];
        $rule = $_POST['rule'];
        $page_rule = $_POST['page'];
        $content_rule = $_POST['content'];
        if(empty($url) || empty($rule) || empty($content_rule)){
            $this->response(null,'链接或规则不能为空',404);
        }

        $list = $this->getList($url,$rule,$page_rule);

        if($list == false){
            return $this->response(null,'列表采集失败',403);
        }

        $content = (new Reptile())->boot($list[0])->content($content_rule);

        if($content != false){
            return $this->response($content);
        }
        return $this->response(null,'采集失败',403);
    }

    public function testDate()
    {
        $url = $_POST['url'];
        $rule = $_POST['rule'];
        $page_rule = $_POST['page'];
        $date_rule = $_POST['date'];
        if(empty($url) || empty($rule) || empty($date_rule)){
            $this->response(null,'链接或规则不能为空',404);
        }

        $list = $this->getList($url,$rule,$page_rule);

        if($list == false){
            return $this->response(null,'列表采集失败',403);
        }
        $date = (new Reptile())->boot($list[0])->date($date_rule);
        if($date != false){
            return $this->response($date);
        }
        return $this->response(null,'采集失败',403);
    }

    public function testTag()
    {
        $url = $_POST['url'];
        $rule = $_POST['rule'];
        $page_rule = $_POST['page'];
        $tag_rule = $_POST['tage'];
        if(empty($url) || empty($rule) || empty($tag_rule)){
            $this->response(null,'链接或规则不能为空',404);
        }

        $list = $this->getList($url,$rule,$page_rule);

        if($list == false){
            return $this->response(null,'列表采集失败',403);
        }

        $tag = (new Reptile())->boot($list[0])->tag($tag_rule);

        if($tag != false){
            return $this->response($tag);
        }
        return $this->response(null,'采集失败',403);
    }



}
