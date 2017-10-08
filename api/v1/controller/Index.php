<?php
namespace api\v1\controller;
use api\common\controller\ApiController;
use api\v1\model\ArticleRecommend;

class Index  extends ApiController
{
    public function rec()
    {   
        $rec=new ArticleRecommend();
        return ArticleRecommend::with(['article'])->where(['is_rec'=>'1'])->order('sort','desc')->select();
   }
}
