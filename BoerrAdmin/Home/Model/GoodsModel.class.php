<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/12 0012
 * Time: 15:14
 */

namespace Home\Model;

use Common\Model\BaseModel;

class GoodsModel extends BaseModel
{
    // 添加商品
    public function addGoods ($addData)
    {
        $result = $this->add($addData);
        return $result;
    }

    // 获得商品
    public function getGood ($goodsId)
    {
        $result = $this->where("goods_id = {$goodsId} AND status <".STATUS)->find();
        return $result;
    }
}