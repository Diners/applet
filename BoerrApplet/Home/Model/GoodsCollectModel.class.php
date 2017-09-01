<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/27 0027
 * Time: 17:21
 */

namespace Home\Model;


use Common\Model\BaseModel;

class GoodsCollectModel extends BaseModel
{
    /**
     * 根据用户id和商品id获取收藏状态
     * @param $userId
     * @param $goodsId
     * @return mixed
     */
    public function getCollectType ($userId, $goodsId)
    {
        $result = $this->where("user_id = {$userId} AND goods_id = {$goodsId}")->find();
        return $result;
    }
}