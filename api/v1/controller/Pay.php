<?php
namespace api\v1\controller;
use think\Controller;
use think\Config;
use think\Loader;
class Pay extends Controller{
    private $config=[];
    
    public function __construct(){
        $config=Config::load(APP_PATH.'extra/alipay.php');
        $this->config=$config['alipay'];
        Loader::import('alipay.pagepay.service.AlipayTradeService',EXTEND_PATH);
        Loader::import('alipay.Alipay',EXTEND_PATH);
    }
    
    public function alipay(){
        Loader::import('alipay.pagepay.buildermodel.AlipayTradePagePayContentBuilder',EXTEND_PATH);
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
    
    public function alipayRefund(){
        Loader::import('alipay.pagepay.buildermodel.AlipayTradeRefundContentBuilder',EXTEND_PATH);
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
    
}