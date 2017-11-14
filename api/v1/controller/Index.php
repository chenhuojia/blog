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
   
  /**
   * 阿里大于短信
   * @return stdClass
   * ***/
    public function sendSms(){
        header('Content-Type: text/plain; charset=utf-8');
        include_once EXTEND_PATH. '/SendSms/api_demo/SmsDemo.php';
        $demo = new \SmsDemo(
            'LTAIQyqofKxMA7Gk',
            '90fshzpFTohLLRIo1iTL0uemoBj0wr'
            );
       $mobile='13622742951';
       //$tempcode='SMS_86625167';
       $tempcode='SMS_86585160';
       //$tempcode='SMS_86595200';
       $week =date("N",time());
       $weekarray=array('一','二','三','四','五','六','日');
       $name='蔡家裕';
       /* for($i=0;$i<6;$i++){
           $asc=mt_rand(65,90);
          $name .=chr($asc);
       } */
       $old=strtotime('2011-08-30 20:00:00');       
       $now=strtotime('now');
       $bg=floor(($now-$old)/(3600*24));
       $today=time();
       $msg=Array('name'=>$name,'week'=>$weekarray[($week-1)],'number'=>mt_rand(1,99),'today'=>$bg);
       //$msg=array('number'=>mt_rand());
       $response = $demo->sendSms("独行侠",$tempcode,$mobile,$msg,"123"); 
       return $response;
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
