<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/7 0007
 * Time: 12:20
 */

namespace Home\Model;

use Common\Model\BaseModel;

class OrderPayModel extends BaseModel
{
    /**
     * 生成支付订单
     * @param $orderFee
     * @param $orderNumber
     * @return mixed
     */
    public function setOrderPay ($orderFee, $orderNumber)
    {
        $insert = [
            'out_trade_no' => $orderNumber,
            'total_fee' => $orderFee,
            'pay_status' => ORDER_NON_PAYMENT,
            'created' => time()
        ];
        $result = $this->add($insert);
        return $result;
    }

    /**
     * 根据主键获得订单
     * @param $orderPayId
     * @return mixed
     */
    public function getOrderPay ($orderPayId)
    {
        $result = $this->where("pay_id = $orderPayId")->find();
        return $result;
    }

    /**
     * 更新订单状态为已支付
     * @param $orderPayId
     * @return bool
     */
    public function updatePayStatus ($orderPayId)
    {
        $saveData = [
            'pay_status' => ORDER_PAYMENT,
        ];
        $result = $this->where("pay_id = {$orderPayId}")->save($saveData);
        return $result;
    }
}