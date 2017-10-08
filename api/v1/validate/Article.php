<?php
namespace api\v1\validate;
use api\common\validate\Base;

class Article extends Base{
    protected $rule = [
        'id'  =>  'require',
    ];
    
    protected $message = [
        'id.require'  =>  '文章id必须',
    ];
}