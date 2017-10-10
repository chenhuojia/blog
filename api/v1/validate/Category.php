<?php
namespace api\v1\validate;
use api\common\validate\Base;

class Category extends Base{
    protected $rule = [
        'id'  =>  'require',
    ];
    
    protected $message = [
        'id.require'  =>  '分类id必须',
    ];
}