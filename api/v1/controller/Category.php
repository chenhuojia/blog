<?php
namespace api\v1\controller;
use api\common\controller\ApiController;
use api\v1\model\Category;
use think\Request;
use api\v1\validate\Category as CategoryVal;
use api\v1\model\Article;
use api\lib\exception\CategoryException;
class Category extends ApiController{
    
    /**
     * 获取分类
     * @return unknown
     * **/
    public function getCategory(){
       $cate=new Category();
       return $cate->where(['is_show'=>'1'])->select();
    }
    
    
    public function getArticles(Request $request){
        (new CategoryVal())->goCheck();
        $id=$request->param('id');
        $page=$request->param('page',0);
        $pageSize=$request->param('pageSize',10);
        return $pageSize;
        $data=(new Article())->where(['cate_id'=>$id,'is_show'=>1])->limit($page,$pageSize)->select();
        if (!$data){
            throw new CategoryException();
        }
        return $data;
    }
}