<?php
namespace api\v1\controller;
use api\common\controller\ApiController;
use think\Request;
use api\v1\validate\Article as ArticleValidate;
use api\v1\model\Article;
use api\lib\exception\ArticleException;
class Article extends ApiController{
    
    //获取文章详情
    public function index(Request $request){
       (new ArticleValidate())->goCheck();
        $id=$request->param('id');
        if (!$data=Article::with(['comment'])->find($id)){
            throw new ArticleException();
        }    
        $logic= \think\Loader::model('Article','logic');
        $data['is_approve']=$logic->isAprove(3,$id);
        return $data;
    }
    
    public function cateArticle(){
        
    }
    
    
}