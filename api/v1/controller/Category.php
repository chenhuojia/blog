<?php
namespace api\v1\controller;
use api\common\controller\ApiController;
use api\v1\model\Category;

class Category extends ApiController{
    
    /**
     * 获取分类
     * @return unknown
     * **/
    public function getCategory(){
       $cate=new Category();
       return $cate->where(['is_show'=>'1'])->select();
    }
    
}