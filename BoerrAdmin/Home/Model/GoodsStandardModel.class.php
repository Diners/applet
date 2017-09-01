<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/12 0012
 * Time: 15:29
 */

namespace Home\Model;

use Common\Model\BaseModel;

class GoodsStandardModel extends BaseModel
{
    // 添加规格
    public function addStandard ($standardAddData)
    {
        $result = $this->add($standardAddData);
        return $result;
    }

    // 更新规格图片
    public function updateStandardImage ($standardId, $updateStandard)
    {
        $result = $this->where("standard_id = {$standardId}")->save($updateStandard);
        return $result;
    }

    // 根据商品id获得商品规格
    public function getStandards ($goodsId)
    {
        $result = $this->where("goods_id = {$goodsId} AND status < ".STATUS)->select();
        return $result;
    }
}