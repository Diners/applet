<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/10 0010
 * Time: 10:45
 */

namespace Home\Model;

use Common\Model\BaseModel;

class BankModel extends BaseModel
{
    /**
     * 根据user_id获得余额记录
     * @param $userId
     * @return mixed
     */
    public function getBank ($userId)
    {
        $result = $this->where("user_id = {$userId}")->find();
        return $result;
    }

    /**
     * 插入记录
     * @param $data
     * @return mixed
     */
    public function insertBank ($data)
    {
        $result = $this->add($data);
        return $result;
    }
}