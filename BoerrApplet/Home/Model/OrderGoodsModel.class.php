<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/31 0031
 * Time: 14:06
 */

namespace Home\Model;

use Common\Model\BaseModel;

class OrderGoodsModel extends BaseModel
{
    /**
     * 订单商品批量插入
     * @param $data
     * @return bool|string
     */
    public function setOrderGoodsAll ($data)
    {
        $ids = $this->addAll($data);

        return $ids;
    }

    /**
     * 获得订单列表，根据商品id数组
     * @param $orderId
     * @return mixed
     */
    public function getOrdersByOrderId ($orderId)
    {
        $result = $this->where("order_id = {$orderId}")->select();
        return $result;
    }

    /**
     * 获得订单列表，根据商品id数组
     * @param $orderId
     * @return mixed
     */
    public function getOrdersByOrderIds ($orderIds)
    {
        $result = $this->where("order_id IN ({$orderIds})")->select();
        return $result;
    }
}