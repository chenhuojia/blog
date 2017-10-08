<?php
use think\Route;
/* Route::post('getCode','v1/Token/getToken');
Route::any('alipay','v1/Pay/alipay');
Route::any('alipayNotify','v1/PayNotify/alipayNotify');
Route::any('alipayRefund','v1/Pay/alipayRefund');
Route::get('index','v1/Index/index'); */
//首页
Route::get('/','v1/Index/index');
Route::get('rec','v1/Index/rec');
Route::get('getCate','v1/Category/getCategory');
Route::get('deatil','v1/Article/index');