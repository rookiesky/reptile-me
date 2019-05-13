<?php
/**
 * Created by PhpStorm.
 * User: rookie
 * Date: 2019-05-12
 * Time: 17:15
 */

namespace App\Controller;

use App\Reptile\Reptile;

class HomeController extends Controller
{
    public function index()
    {
        include BASE_PATH . 'view/index.html';
    }

    public function create()
    {
        include BASE_PATH . 'view/create.html';
    }

    /**
     * 测试列表采集规则
     */
    public function testList()
    {
        $url = $_POST['url'];
        $rule = $_POST['rule'];
        if(empty($url) || empty($rule)){
            $this->response(null,'链接或规则不能为空',404);
        }
        $rule = explode('&&&',$rule);

        $data = (new Reptile())->listUrl($url,$rule);
        if(isset($data[0]['link'])){
            return $this->response(array_column($data,'link'));
        }
        return $this->response(null,'采集失败',403);
    }


    public function testPage()
    {
        $url = $_POST['url'];
        $rule = $_POST['rule'];
        if(empty($url) || empty($rule)){
            $this->response(null,'链接或规则不能为空',404);
        }

        $data = (new Reptile())->listPage($url,explode('&&&',$rule));
        dump($data);die;

    }
    
    
}
