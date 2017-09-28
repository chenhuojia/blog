<?php
class Alipay { 
    private $config=[];    
    public function __construct(){
        require_once (dirname(__FILE__).'/config.php');
        $this->config=$config;
        require_once (dirname(__FILE__).'/pagepay/service/AlipayTradeService.php');        
    }
    /***
     * 扫码支付
     * **/
    public function alipay(){        
        require_once (dirname(__FILE__).'pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');
        $out_trade_no = time();    
        //订单名称，必填
        $subject = 'testst';    
        //付款金额，必填
        $total_amount = 0.01;   
        //商品描述，可空
        $body = '测试测试';    
    	//构造参数
    	$payRequestBuilder = new \AlipayTradePagePayContentBuilder();
    	$payRequestBuilder->setBody($body);
    	$payRequestBuilder->setSubject($subject);
    	$payRequestBuilder->setTotalAmount($total_amount);
    	$payRequestBuilder->setOutTradeNo($out_trade_no);    
    	$aop = new \AlipayTradeService($this->config);
    	$response = $aop->pagePay($payRequestBuilder,$this->config['return_url'],$this->config['notify_url']);    
    	//输出表单
    	var_dump($response);
    }
    
    /***
     * 退款
     * **/
    public function alipayRefund(){
        require_once (dirname(__FILE__).'pagepay/buildermodel/AAlipayTradeFastpayRefundQueryContentBuilder.php');
        //商户订单号，商户网站订单系统中唯一订单号
        $out_trade_no = 1505378480;
        //支付宝交易号
        $trade_no = '';
        //请二选一设置
        //需要退款的金额，该金额不能大于订单金额，必填
        $refund_amount = 0.01;
        //退款的原因说明
        $refund_reason = '正常退款';       
        //标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传
        $out_request_no = '';       
        //构造参数
        $RequestBuilder=new \AlipayTradeRefundContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setOutRequestNo($out_request_no);
        $RequestBuilder->setRefundReason($refund_reason);  
        $aop = new \AlipayTradeService($this->config);
        $response = $aop->Refund($RequestBuilder);
        /* [
            "code"=> "10000", 
            "msg"=> "Success",
            "buyer_logon_id"=>"112***@qq.com",
            "buyer_user_id"=>"2088702695023772",
            "fund_change"=>"Y",
            "gmt_refund_pay"=>"2017-09-14 17:07:29",
            "out_trade_no"=> "1505378943", 
            "refund_fee"=>"0.01",
            "send_back_fee"=> "0.00",
            "trade_no"=> "2017091421001004770213704343"
        ]; */
        var_dump($response);;
    }
    
    /***
     * 回调验证
     * **/
    public function alipayNotify(){
        /* $arr=array (
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
         ); */
        $alipaySevice = new \AlipayTradeService($this->config);
        //$alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);
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