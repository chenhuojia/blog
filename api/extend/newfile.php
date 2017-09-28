<?php
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
print_r($arr);exit;
/**
 * 验签方法
 * @param $arr 验签支付宝返回的信息，使用支付宝公钥。
 * @return boolean
 */
function check($arr){
    $rsaPublicKey=  "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhNvojSoGEAjlnl1aKkhRkaUk/n7SQh4sgPqRgFATOkvx/J75AbmCvzD00GFdvrgz6soK4wB5ozr4r0NraISOPHHG9yJpl3YmXvgBFzNOG5PrZ3+3LSOVi8GYXe1Rc0KeUPgmYX9ZycNsRvZeS8e4GDrhESD7PaXGCiUN4BJKxsAVvbBQyf01DKPPAMYDKagu/2gtxY/ZVpOs4d75pQVZIr4vHhBD/MJBxNNz7ZWhUKHk7GRlvOtmQhDRhsIiucB3qvQIgnUp07qRGALwgVUesSnWyTLC/AyZteS8h7TlAYaKc2BBMtUqSyLF/CmugJNOjxehSXYLa8nE+h91jQ+QjQIDAQAB";
    $result = rsaCheckV1($arr,$rsaPublicKey,"RSA");
    return $result;
}
/** rsaCheckV1 & rsaCheckV2
 *  验证签名
 *  在使用本方法前，必须初始化AopClient且传入公钥参数。
 *  公钥是否是读取字符串还是读取文件，是根据初始化传入的值判断的。
 **/
function rsaCheckV1($params, $rsaPublicKey,$signType='RSA') {
    $sign = $params['sign'];
    $params['sign_type'] = null;
    $params['sign'] = null;
    return verify(getSignContent($params), $sign, $rsaPublicKey,$signType);
}
/**
 * 校验$value是否非空
 *  if not set ,return true;
 *    if is null , return true;
 **/
function checkEmpty($value) {
    if (!isset($value))
        return true;
        if ($value === null)
            return true;
            if (trim($value) === "")
                return true;

                return false;
}

function verify($data, $sign, $alipayPublicKey, $signType = 'RSA') {
    if(checkEmpty($alipayPublicKey)){
        $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($alipayPublicKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
    }
    if ("RSA2" == $signType) {
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
    } else {
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
    }

    if(!checkEmpty($alipayPublicKey)) {
        //释放资源
        openssl_free_key($res);
    }

    return $result;
}

function getSignContent($params) {
    ksort($params);
    $stringToBeSigned = "";
    $i = 0;
    foreach ($params as $k => $v) {
        if (false === checkEmpty($v) && "@" != substr($v, 0, 1)) {

            // 转换成目标字符集
            $v = $this->characet($v, "UTF-8");

            if ($i == 0) {
                $stringToBeSigned .= "$k" . "=" . "$v";
            } else {
                $stringToBeSigned .= "&" . "$k" . "=" . "$v";
            }
            $i++;
        }
    }

    unset ($k, $v);
    return $stringToBeSigned;
}