<?php
namespace api\v1\controller;
use api\common\controller\ApiController;
use think\Request;
use api\v1\validate\Article as ArticleValidate;
use api\v1\model\Article;

class Article extends ApiController{
    
    public function index(Request $request){
        (new ArticleValidate())->goCheck();
        $id=$request->get('id');
        return Article::with(['images','comment'])->find($id);        
        
    }
    
    public function cateArticle(){
        
    }
    
    
}