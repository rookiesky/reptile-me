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
use App\Tools\Cache;


class HomeController extends Controller
{
    public function index()
    {
        //$content = new ReptileContent();
        //$content->start();
       // $this->response(null,'error',404);
        include BASE_PATH . 'view/index.html';
    }

    /**
     * 列表视图
     */
    public function listView()
    {
        $data = Loc::boot()->select('web',['id','title','link','ruku_type','ruku_id','list_total']);
        include BASE_PATH . '/view/list.html';
    }

    /**
     * 编辑页面
     */
    public function show()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if(empty($id)){
            return $this->response(null,'NOT PAGE',404);
        }
        $data = Loc::boot()->get('web','*',['id'=>$id]);
        if(empty($data)){
            return $this->response(null,'NOT PAGE',404);
        }
        include BASE_PATH . '/view/show.html';
    }

    /**
     * 处理编辑逻辑
     */
    public function update()
    {
        $data = $_POST;
        $mysql = Loc::boot();
        $result = $mysql->get('web',['id'],['id'=>$data['id']]);

        if(empty($result)){
            return $this->response(null,'规则不存在',404);
        }

        try{
            $mysql->update('web',$data,['id'=>$result['id']]);
            (new Cache())->put('web_links_' . $result['id'],$data);
            return $this->response();

        }catch (\Exception $exception){
            return $this->response([$exception->getMessage()],'mysql update error',500);
        }

    }

    public function destroy()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        if(empty($id)){
            return $this->response(null,'id empty',404);
        }

        $mysql = Loc::boot();

        $result = $mysql->get('web','id',['id'=>$id]);

        if(empty($result)){
            return $this->response(null,'id empty',404);
        }

        if($mysql->delete('web',['id'=>$result])){
            (new Cache())->forget('web_links_' . $result);
            return $this->response();
        }
        return $this->response(null,'mysql delete error',500);

    }


    /**
     * 创建视图
     */
    public function create()
    {
        include BASE_PATH . 'view/create.html';
    }

    /**
     * 处理创建逻辑
     */
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
