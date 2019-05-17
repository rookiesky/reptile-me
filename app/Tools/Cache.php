<?php

namespace App\Tools;

/**
 * Class Cache
 *
 * @package \App\Tools
 */
class Cache
{
    protected $file = BASE_PATH . 'store/cache/cache.php';

    /**
     * 写入缓存
     * @param $key key
     * @param $data value
     *
     * @return bool|int
     */
    public function put($key,$data)
    {
        if(!is_file($this->file)){
            return $this->setFile([$key=>$data]);
        }
        $result = $this->getFile();
        $result[$key] = $data;
        return $this->setFile($result);
    }

    /**
     * 获取数据
     * @param $key
     *
     * @return |null
     */
    public function get($key)
    {
        if(!is_file($this->file)){
            return null;
        }
        $result = $this->getFile();
        if(isset($result[$key])){
            return $result[$key];
        }
        return null;
    }

    /**
     * 删除指定缓存
     * @param $key
     *
     * @return bool
     */
    public function forget($key)
    {
        if(!is_file($this->file)){
            return false;
        }
        $result = $this->getFile();
        if(isset($result[$key])){
            unset($result[$key]);
            $this->setFile($result);
            return true;
        }
        return false;
    }

    /**
     * 清空所有缓存
     * @return bool
     */
    public function flush()
    {
        if(!is_file($this->file)){
            return false;
        }
        $result = '';
        $this->setFile($result);
        return true;
    }

   protected  function setFile($data)
   {
        return file_put_contents($this->file,serialize($data));
   }

   protected function getFile()
   {
       return unserialize(file_get_contents($this->file));
   }

}
