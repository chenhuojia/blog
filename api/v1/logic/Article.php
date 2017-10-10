<?php
namespace api\v1\logic;
use think\Model;
use api\v1\model\Approve;
class Article extends Model{
    
    //是否点赞
    public function isAprove($user_id,$art_id){
       if (empty($user_id) || empty($art_id)){
            return false;
        }
       if ((new Approve())->where(['user_id'=>$user_id,'art_id'=>$art_id,'is_approve'=>1,'is_show'=>1])->find()){
           return true;
       }
       return false;
    }
    
}