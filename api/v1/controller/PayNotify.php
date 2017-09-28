<?php
namespace api\v1\controller;
use think\Controller;
use think\Config;
use think\Loader;
class PayNotify extends Controller{
    
    public function alipayNotify(){
        $config=Config::load(APP_PATH.'extra/alipay.php');
        Loader::import('alipay.pagepay.service.AlipayTradeService',EXTEND_PATH);
        $arr=array (
            'gmt_create' => '2017-09-14 16:49:07',
            'charset' => 'UTF-8',
            'gmt_payment' => '2017-09-14 16:49:21',
            'notify_time' => '2017-09-14 16:49:22',
            'subject' => 'testst',
            'sign' => 'YFe7qtcd5wi3FTMH7YaZcYp9MteE8gc/sNL9H3oRVzrU1YL3346c25yLlwwy5/Uics2Jez5M0AfRR/LPFal3dd1Am1ZLX6omUadUSBH40NzaI/oDE6fNssNd9BQLZemnOPhlN6aXGLxr7EfAaxKwNeRQl9H3RXOQEdyzmwUUlhyZQUcCB0WzwaIYzJoDpfql4/fas7VX3iXotyy2jPlo6nRTMtFR3oqGIBx6j1P7/soZeeN6DA5WpiAWghtp5VSFJn1Bkfu5cGk3EHd8UgrF2m5wAfMvYitySFVJfTWib7QUauTbEzMlqK7gtgkroJW4c4gIHoKoa00v2GaFUwmstg==',
            'buyer_id' => '2088702695023772',
            'body' => '测试测试',
            'invoice_amount' => '0.01',
            'version' => '1.0',
            'notify_id' => '942ea9a6eaaf951b1d91235b03474aalxy',
            'fund_bill_list' => '[{"amount":"0.01","fundChannel":"ALIPAYACCOUNT"}]',
            'notify_type' => 'trade_status_sync',
            'out_trade_no' => '1505378943',
            'total_amount' => '0.01',
            'trade_status' => 'TRADE_SUCCESS',
            'trade_no' => '2017091421001004770213704343',
            'auth_app_id' => '2017082408354802',
            'receipt_amount' => '0.01',
            'point_amount' => '0.00',
            'app_id' => '2017082408354802',
            'buyer_pay_amount' => '0.01',
            'sign_type' => 'RSA2',
            'seller_id' => '2088521415403012',
        );        
        $alipaySevice = new \AlipayTradeService($config['alipay']);
        //$alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr); 
        var_dump($result);exit;
        if($result) {    
            $out_trade_no = $_POST['out_trade_no'];
            $trade_no = $_POST['trade_no'];
            $trade_status = $_POST['trade_status'];            
            if($_POST['trade_status'] == 'TRADE_FINISHED') {        
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
        
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                    self::updateOrder($order_sn);   
            }            
            echo "success";	//请不要修改或删除
        }else {
            //验证失败
            echo "fail";
        }
    } 
    
     
        
}