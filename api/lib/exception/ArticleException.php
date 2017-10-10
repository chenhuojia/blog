<?php
namespace api\lib\exception;
class ArticleException extends BaseException{
    public $code=404;
    public $msg='文章不存在';
    public $errorCode=40000;
}