<?php
namespace api\v1\model;
use think\Model;

class Article extends Model{
    protected $table='bk_article';
    
    //获取图片
    public function images(){
        return $this->hasMany('ArticleImages','art_id','art_id');
    }
    //获取评论
    public function comment(){
        return $this->hasMany('Discuss','art_id','art_id');
    }
}