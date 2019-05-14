<?php

namespace App\Controller;

/**
 * Class Controller
 *
 * @package \App\Controller
 */
class Controller
{
    public function response($data = null, $msg = 'success',$status = 200)
    {
        header('Content-Type:application/json; charset=utf-8');
        http_response_code($status);
        echo json_encode([
            'message' => $msg,
            'data' => $data
        ],JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * 分页重组
     * @param        $url
     * @param        $replace
     * @param string $tag
     *
     * @return mixed
     */
    protected function replaceUrl($url,$replace,$tag = '(*)')
    {
        return str_replace($tag,$replace,$url);
    }
}
