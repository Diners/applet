<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/2 0002
 * Time: 10:56
 */

namespace Home\Controller\Order;

use Common\Controller\BaseController;
use Home\Model\AddressModel;
use Home\Model\GoodsBrandModel;
use Home\Model\GoodsImageModel;
use Home\Model\GoodsModel;
use Home\Model\GoodsStandardModel;
use Home\Model\OrderGoodsModel;
use Home\Model\OrderModel;
use Home\Model\OrderPayModel;

class GetOrderController extends BaseController
{
    // 订单详情接口
    public function index()
    {
        $orderId = I('get.order_pay_id', 0, 'intval');
        $userId = I('get.user_id', 0, 'intval');

            if (!$orderId) {
                $errMessage = [
                    'code' => 1,
                    'message' => '订单id不能为空！'
                ];
                $this->ajaxReturn($errMessage);
                return false;
            }
        $orderModel = new OrderModel();
        $orderGoodsModel = new OrderGoodsModel();
        $orderPayModel = new OrderPayModel();
        $goodsModel = new GoodsModel();
        $goodsImageModel = new GoodsImageModel();
        $standardModel = new GoodsStandardModel();
        $addressModel = new AddressModel();
        $brandModel = new GoodsBrandModel();
        $result = [];

        // 支付订单信息
        $orderPayData = $orderPayModel->getOrderPay($orderId);
        // 订单信息
        $orderData = $orderModel->getOrderByPayId($orderId);

        if (!$orderData) {
            $errMessage = [
                'code' => 2,
                'message' => '订单不存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $orderIds = array_column($orderData, 'order_id');
        $orderIds = implode(',', $orderIds);
        // 订单商品信息
        $goodsData = $orderGoodsModel->getOrdersByOrderIds($orderIds);
        if (!$goodsData) {
            $errMessage = [
                'code' => 3,
                'message' => '该订单没有商品！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $goodsSort = [];
        // 格式数组
        foreach ($goodsData as $v) {
            $v1 = $v['brand_id'];
            $goodsSort[$v1][] = $v;
        }

        //   获得默认地址
        $addressMessage = $addressModel->getDefaultAddress($userId);
        if ($addressMessage) {
            $result['address_message'] = [
                'user_rec_name' => $addressMessage['user_rec_name'],
                'user_rec_mobile' => $addressMessage['user_rec_mobile'],
                'address_id' => $addressMessage['address_id'],
                'user_address' => $addressMessage['user_address'].$addressMessage['user_detail_addr'],
            ];
        } else {
            $result['address_message'] = [];
        }

        foreach ($goodsSort as $key => $val) {
            $standardIds = array_column($val, 'standard_id');

            // 获得品牌信息，（$key是品牌id）
            $brandMessage = $brandModel->getBrandOne($key);

            $result['order_list'][$key]['brand_message'] = [
                'brand_id' => $key,
                'brand_name' => $brandMessage['brand_name'],
                'brand_logo' => $brandMessage['brand_logo'],
            ];
            // 获得订单信息
            $orderData = $orderModel->getOrder($val[0]['order_id']);

            $result['order_list'][$key]['order_message'] = [
                'order_id' => $orderData['order_id'],
                'order_price' => $orderData['order_price'],
                'remark' => $orderData['remark'],
            ];
            foreach ($val as $k => $v) {
                $goodsMessage = $goodsModel->getGoodsOne($v['goods_id']);
                $standardData = $standardModel->getStandardByStandardId($standardIds);
                $result['order_list'][$key]['goods_list'][$k]['goods_id'] = $goodsMessage['goods_id'];
                $result['order_list'][$key]['goods_list'][$k]['goods_name'] = $goodsMessage['goods_name'];
                $result['order_list'][$key]['goods_list'][$k]['goods_number'] = $v['goods_number'];
                $result['order_list'][$key]['goods_list'][$k]['goods_thumb'] = $goodsImageModel->getGoodsImagesByType($goodsMessage['goods_id'], 1)['thumb_url'];
                $result['order_list'][$key]['goods_list'][$k]['price'] = $standardData['price'];
                $result['order_list'][$key]['goods_list'][$k]['color'] = $standardData['color'];
            }

        }
        $result['total_fee'] = $orderPayData['total_fee'];
        $result['order_list'] = array_values($result['order_list']);
        $this->ajaxReturn($result);
    }
}