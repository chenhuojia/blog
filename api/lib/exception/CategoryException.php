<?php
namespace api\lib\exception;
class CategoryException extends BaseException{
    public $code = 404;
    public $msg = '改分类没有文章';
    public $errorCode = 40000;
}