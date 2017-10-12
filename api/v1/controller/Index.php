<?php
namespace api\v1\controller;
use api\common\controller\ApiController;
use api\v1\model\ArticleRecommend;
use think\Request;
use api\lib\exception\ArticleException;
class Index  extends ApiController
{
    /**
     * 首页推荐
     * @throws ArticleException
     * @return array
     * ***/
    public function rec()
    {   
        $rec=new ArticleRecommend();
        $data=ArticleRecommend::with(['article'])->where(['is_rec'=>'1'])->order('sort','desc')->select();
        if (empty($data)){
            throw new ArticleException();
        }
        return $data;
    }
   
  
    

    
   public function redisc(Request $request){
       /* $options = [
           // 缓存类型为File
           'type'  =>  'redis',
           // 缓存有效期为永久有效
           //缓存前缀
           'prefix'=>  'ip_',
           // 指定缓存目录
           'host'       => '127.0.0.1',
       ];
      Cache::connect($options);
      Cache::inc('127.0.0.1'); */    
      $redis=new \Redis();
      $redis->connect('127.0.0.1','6379',1);
      $ip=$_SERVER['REMOTE_ADDR'];
      $count=$redis->get($ip);
      if ($count >= 5){
          return $count;
      }else{
          $time=mktime(23,59,59,date('m'),date('d'),date('Y'));
          $redis->incr($ip);
          $redis->expire($ip,$time);
      } 
      return true;
   }
}
