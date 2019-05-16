<?php

namespace App\Article;

/**
 * Class TypechoArticle
 *
 * @package \App\Article
 */
class TypechoArticle extends Article implements ArticleInterface
{

    protected $mysql = null;
    protected $cid = '';

    public function put($article,$web)
    {
        //增加文章
        $time  = empty($article['date']) ? time() : strtotime($article['date']);
        $data = [
           'title' => $article['title'],
           'slug' => $article['title'],
           'created' => $time,
           'modified' => $time,
            'text' => $article['content'],
            'allowComment' => 1,
            'allowPing' => 1,
            'allowFeed' => 1,
            'authorId' => 1
        ];
        $this->mysql = $mysql = self::mysql($web);

        $mysql->insert('contents',$data);
        $this->cid = $cid = $mysql->id();


        $this->addSort($article['tag'],$web['ruku_id']);

        $this->tags($article['tag']);
        return true;
    }

    protected function tags($tag)
    {
        if(is_string($tag)){
           return $this->addTag($tag);
        }

        foreach ($tag as $item){
            $this->addTag($item);
        }
    }

    protected function addTag($tag)
    {
        $table = 'metas';

        $result = $this->mysql->get($table,'*',[
            'name' => $tag,
            'type' => 'tag'
        ]);

        if(empty($result)){
            $this->mysql->insert($table,[
                'name' => $tag,
                'slug' => $tag,
                'type' => 'tag',
                'count' => 1
            ]);
            $mid = $this->mysql->id();
        }else{

            $this->mysql->update($table,[
                'count' => $result['count'] + 1
            ],[
                'mid' => $result['mid']
            ]);
            $mid = $result['mid'];
        }

        $this->mysql->insert('relationships',[
            'cid' => $this->cid,
            'mid' => $mid
        ]);

    }

    /**
     * 添加关联分类 并更新分类文章数
     * @param $tag 采集的标签
     * @param $ruku_id  指定的分类
     *
     * @return false
     */
    protected function addSort($tag,$ruku_id)
    {
       $sort =  $this->sort($ruku_id,$tag);
       if($sort == false){
           $sort = 1;
       }
       $sort = $this->mysql->get('metas','*',[
           'mid' => $sort,
           'type' => 'category'
       ]);
       if(empty($sort)){
           return false;
       }

       $this->mysql->insert('relationships',['cid'=>$this->cid,'mid'=>$sort['mid']]);

       $this->mysql->update('metas',[
           'count' => $sort['count'] + 1
       ],[
           'mid' => $sort['mid']
       ]);

    }

}
