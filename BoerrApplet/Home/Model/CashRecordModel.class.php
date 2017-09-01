<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/9 0009
 * Time: 17:41
 */

namespace Home\Model;

use Common\Model\BaseModel;

class CashRecordModel extends BaseModel
{
    /**
     * 添加纪录
     * @param $userId
     * @param $orderPayId
     * @param $money
     * @return mixed
     */
    public function addCashStatus ($userId, $orderPayId, $money)
    {
        $addData = [
            'user_id' => $userId,
            'order_id' => $orderPayId,
            'money' => $money,
            'time' => time(),
        ];
        $result = $this->add($addData);
        return $result;
    }
}