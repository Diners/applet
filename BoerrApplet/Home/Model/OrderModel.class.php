<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:47
 */

namespace Home\Model;


use Common\Model\BaseModel;

class OrderModel extends BaseModel
{
    // 添加订单
    public function addOrder($brandId, $orderPrice, $buyUserId, $orderPayId)
    {
        $data = [
            'brand_id' => $brandId,
            'order_price' => $orderPrice,
            'buy_user_id' => $buyUserId,
            'order_type' => ORDER_NON_PAY,
            'pay_id' => $orderPayId,
            'status' => 1,
            'created' => time()
        ];
        $orderId = $this->add($data);
        return $orderId;
    }

    /**
     * 获取单个订单
     * @param $orderId
     * @return mixed
     */
    public function getOrder ($orderId)
    {
        $result = $this->where("order_id = {$orderId}")->find();

        return $result;
    }

    /**
     * 根据支付订单id获得订单列表
     * @param $orderPayId
     * @return mixed
     */
    public function getOrderByPayId ($orderPayId)
    {
        $result = $this->where("pay_id IN ({$orderPayId})")->select();

        return $result;
    }

    /**
     * 支付成功后更新订单状态
     * @param $orderPayId
     * @param $addressId
     * @return bool
     */
    public function updateOrderPayStatus ($orderPayId, $addressId)
    {
        $saveDate = [
            'order_type'=> ORDER_NON_SEND,
            'address_id' => $addressId,
            'buy_time' => time(),
        ];
        $result = $this->where("pay_id = {$orderPayId}")->save($saveDate);
        return $result;
    }
}