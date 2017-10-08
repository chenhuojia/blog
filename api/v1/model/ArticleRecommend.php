<?php
namespace api\v1\model;
use think\Model;

class ArticleRecommend extends Model{
    
    protected $table='bk_article_recommend';
    
    public function article(){
        return $this->hasOne('Article','art_id','id','','left');
    }
}