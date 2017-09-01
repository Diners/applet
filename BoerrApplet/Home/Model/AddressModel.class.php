<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/2 0002
 * Time: 14:43
 */

namespace Home\Model;

use Common\Model\BaseModel;

class AddressModel extends BaseModel
{
    /**
     * 获得地址
     * @param $addressId
     * @return mixed
     */
    public function getAddressById ($addressId)
    {
        $result = $this->where("address_id = {$addressId}")->find();
        return $result;
    }

    /**
     * 获得用户默认地址
     * @param $userId
     * @return mixed
     */
    public function getDefaultAddress ($userId)
    {
        $result = $this->where("user_id = {$userId} AND user_imp = 1")->find();
        return $result;
    }
}