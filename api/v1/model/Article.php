<?php
namespace api\v1\model;
use think\Model;

class Article extends Model{
    protected $table='bk_article';
    
    public function images(){
        return $this->hasMany('ArticleImages','art_id','art_id');
    }
    
    public function comment(){
        return $this->hasMany('Discuss','art_id','art_id');
    }
}