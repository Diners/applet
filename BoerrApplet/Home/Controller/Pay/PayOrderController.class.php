<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/4 0004
 * Time: 12:19
 */

namespace Home\Controller\Pay;

use Common\Controller\BaseController;
use Home\Model\OrderPayModel;

class PayOrderController extends BaseController
{
    // 微信统一下单
    public function index ()
    {
        $openId = I('post.openid', '', 'trim');
        $orderPayId = I('post.order_pay_id', 0, 'intval');

        if (!$openId || !$orderPayId) {
            $errMessage = [
                'code' => 1,
                'message' => '提交参数不能为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $orderModel = new OrderPayModel();
        // 获得订单信息
        $orderInfo = $orderModel->getOrderPay($orderPayId);
        if (!$orderInfo) {
            $errMessage = [
                'code' => 1,
                'message' => '订单不存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 随机字符串
        $nonceStr = $this->getRandChar(20);
        $payUrl = C('WX_PAY_URL');
        // 统一下单请求参数
        $body = '+2微杂制';
        $payRequestData = [
            'appid' => C('APP_ID'),
            'mch_id' => C('WX_MCH_ID'),
            'nonce_str' => $nonceStr,
            'body' => $body,
            'out_trade_no' => $orderInfo['out_trade_no'],
            'total_fee' => (int)($orderInfo['total_fee']*100), // 转换单位为'分'
            'spbill_create_ip' =>  $_SERVER['SERVER_ADDR'],
            'notify_url' => 'https://www.boerr.cn/Home/Pay/PaySuccessCallback',
            'trade_type' => 'JSAPI',
            'openid' => $openId,
        ];
        // 生成签名
        $payRequestData['sign'] = $this->getSign($payRequestData);
        // 请求微信接口
        $xmlReturn = $this->postRequestXml($payUrl, $payRequestData);
        // xml转array
        $resultData = $this->xmlToArray($xmlReturn);

        // 判断是否返回成功
        if ($resultData['return_code'] == 'SUCCESS') {
            $return = [
                'appId' => C('APP_ID'),
                'package' => 'prepay_id='.$resultData['prepay_id'],
                'nonceStr' => $resultData['nonce_str'],
                'timeStamp' => time(),
                'signType' => 'MD5'
            ];
            $return['paySign'] = $this->getSign($return);
            $this->ajaxReturn($return);
        } else {
            $errMessage = [
                'code' => 2,
                'message' => '微信统一下单失败'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

    }
}