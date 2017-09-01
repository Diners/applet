<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/29 0029
 * Time: 15:19
 */

namespace Home\Controller\Order;

use Common\Controller\BaseController;
use Home\Model\GoodsModel;
use Home\Model\OrderGoodsModel;
use Home\Model\OrderModel;
use Home\Model\OrderPayModel;

class AddOrderController extends BaseController
{
    // 添加订单接口
    public function index ()
    {
        $goodsId = I('post.goods_id');
        $goodsNumber = I('post.goods_number');
        $standardId = I('post.standard_id');
        $orderPrice = I('post.order_price', 0, 'floatval');
        $buyUserId = I('post.user_id', 0, 'intval');

        // 参数不能为空
        if (!$goodsId) {
            $errMessage = [
                'code' => 1,
                'message' => 'goodsId为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }if (!$goodsNumber) {
            $errMessage = [
                'code' => 1,
                'message' => '$goodsNumber为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }if (!$standardId) {
            $errMessage = [
                'code' => 1,
                'message' => '$standardId为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }if (!$orderPrice) {
            $errMessage = [
                'code' => 1,
                'message' => '$orderPrice为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }if (!$buyUserId) {
            $errMessage = [
                'code' => 1,
                'message' => '$buyUserId为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $goodsId = explode(',',$goodsId);
        $goodsNumber = explode(',',$goodsNumber);
        $standardId = explode(',',$standardId);

        // 参数必须是数组
        if (!is_array($goodsId) || !is_array($goodsNumber) || !is_array($standardId)) {
            $errMessage = [
                'code' => 5,
                'message' => '参数必须是数组！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 参数长度不一样
        if (count($goodsId) != count($goodsNumber) && count($goodsId) != count($standardId)) {
            $errMessage = [
                'code' => 1,
                'message' => '数组参数长度必须一样！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $goodsModel = new GoodsModel();
        // 获得商品信息
        $goodsInfo = $goodsModel->getGoodsByGoodsStandard($goodsId,$standardId);

        foreach ($goodsInfo as $key => &$val) {
            $val['goods_number'] = $goodsNumber[$key];
        }
        // 商品信息为空
        if (!$goodsInfo) {
            $errMessage = [
                'code' => 2,
                'message' => '商品不存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $orderModel = new OrderModel();
        $orderGoodsModel = new OrderGoodsModel();
        $orderPayModel = new OrderPayModel();

        $goodsSort = [];
        // 格式数组
        foreach ($goodsInfo as $v) {
            $v1=$v['brand_id'];
            $goodsSort[$v1][]=$v;
        }
        // 生成随机订单号
        $order_number = time().rand(100,999);
        // 生成支付订单
        $orderPayId = $orderPayModel->setOrderPay($orderPrice, $order_number);
        if (!$orderPayId) {
            $errMessage = [
                'code' => 3,
                'message' => '生成支付订单失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        // 批量添加订单
        foreach ($goodsSort as $key => $val) {
            $orderPrice = 0;
            // 计算订单价格
            foreach ($val as $key1 => $val1) {
                $orderPrice += $val1['price']*$val1['goods_number'];

            }

            // 添加商品订单
            $orderId = $orderModel->addOrder($key, $orderPrice, $buyUserId, $orderPayId);
            if (!$orderId) {
                $errMessage = [
                    'code' => 4,
                    'message' => '生成商品订单失败！'
                ];
                $this->ajaxReturn($errMessage);
                return false;
            }
            $orderGoodsData = [];
            foreach ($val as $k => $v) {
                $orderGoodsData[$k]['order_id'] = $orderId;
                $orderGoodsData[$k]['goods_id'] = $v['goods_id'];
                $orderGoodsData[$k]['brand_id'] = $v['brand_id'];
                $orderGoodsData[$k]['standard_id'] = $v['standard_id'];
                $orderGoodsData[$k]['goods_number'] = $v['goods_number'];
                $orderGoodsData[$k]['status'] = 1;
                $orderGoodsData[$k]['created'] = time();
            }

            // 添加详细商品
            $orderGoodsModel->setOrderGoodsAll($orderGoodsData);
        }
        $return = [
            'order_pay_id' => $orderPayId,
        ];
        return $this->ajaxReturn($return);
    }
}