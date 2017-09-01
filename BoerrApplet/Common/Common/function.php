<?php
//自定义过滤函数
function clearXSS($data)
{
    require_once './htmlpurifier/HTMLPurifier.auto.php';
    // 生成默认的配置
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    // 设置允许出现的标签
    $_clean_xss_config->set('HTML.Allowed', 'div,b,strong,i,em,&nbsp,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    // 设置允许出现的css样式
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上可以使用target属性
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    // 根据配置生成对象
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    // 过滤数据
    return $_clean_xss_obj->purify($data);
}

if (!function_exists('http_get')) {
    /**
     * http get 请求
     * @param  string
     */
    function http_get($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}
//封装p()函数；
if (!function_exists('p')) {
    function p($param, $code = 0)
    {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
        if ($code == 1) {
            die;
        }
    }
}
//
//function checkorderstatus($order_num){
//    $Ord=M('buys');
//    $ordstatus=$Ord->where('order_num='.$order_num)->getField('status');
//
//    if($ordstatus==0){
//        return true;
//    }else{
//        return false;
//    }
//}
//
////处理订单函数
////更新订单状态，写入订单支付后返回的数据
//function orderhandle($parameter){
//    $data = M('buys')->where("order_num='{$parameter}'")->find();
//    $data1['status'] = 0;
//    $save = M('buys')->where("order_num='{$parameter}'")->save($data1);
//    $updatezhuangtai=M('order')->where("cart='{$parameter}'")->save($data1);
//}
/*-----------------------------------
2013.8.13更正
下面这个函数，其实不需要，大家可以把他删掉，
具体看我下面的修正补充部分的说明
------------------------------------*/

// //获取一个随机且唯一的订单号；
// function getordcode(){
//     $Ord=M('order');
//     $numbers = range (10,99);
//     shuffle ($numbers);
//     $code=array_slice($numbers,0,4);
//     $ordcode=$code[0].$code[1].$code[2].$code[3];
//     $oldcode=$Ord->where("ordcode='".$ordcode."'")->getField('ordcode');
//     if($oldcode){
//         getordcode();
//     }else{
//         return $ordcode;
//     }
/**
 * http post 请求
 * @param  string $url 请求网址
 * @param  string $data post数据
 */
function http_post($url, $data)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //curl_setopt($ch, CURLOPT_USERAGENT, "(kingnet oa web server)");
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function Ajaxsuccess($code = 0, $info = '', $jsonpCallback = '')
{
    $out = [
        'code' => $code,
        'info' => $info,
    ];
    if (!empty($jsonpCallback)) {
        return $jsonpCallback . '(' . json_encode($out) . ')';
    }
    return json_encode($out);
}

/**
 * 生成二维码
 * @param  string $url url连接
 * @param  integer $size 尺寸 纯数字
 */
function qrcode($url, $size = 8)
{
    Vendor('Phpqrcode.phpqrcode');
    //$fileName='/public/Uploads/'.uniqid('wx_',true).'png';
    QRcode::png($url, false, QR_ECLEVEL_L, $size, 2, false, 0xFFFFFF, 0x000000);
    //return $fileName;
}

/**
 * 微信扫码支付
 * @param  array $order 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)
 */
function weixinpay($order)
{
    $order['trade_type'] = 'NATIVE';
    Vendor('Weixinpay.Weixinpay');
    $weixinpay = new \Weixinpay();
    $weixinpay->pay($order);
}