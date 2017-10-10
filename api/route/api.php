<?php
use think\Route;
/* Route::post('getCode','v1/Token/getToken');
Route::any('alipay','v1/Pay/alipay');
Route::any('alipayNotify','v1/PayNotify/alipayNotify');
Route::any('alipayRefund','v1/Pay/alipayRefund');
Route::get('index','v1/Index/index'); */
//首页
Route::get('/','v1/Index/index');
Route::get(':version/rec',':version/Index/rec');
Route::get(':version/getCate',':version/Category/getCategory');
Route::get(':version/deatil/:id',':version/Article/index');
Route::get(':version/cate/:id/:page/:pagesize',':version/Category/getArticles');