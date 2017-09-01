<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:45
 */

namespace Home\Model;


use Common\Model\BaseModel;

class GoodsStandardModel extends BaseModel
{
    /**
     * 根据商品id获取规格
     * @param $goodsId
     */
    public function getStandardByGoodsId ($goodsId)
    {
        $result = $this->where("goods_id = {$goodsId} AND".STATUS)->select();
        return $result;
    }

    /**
     * 获得规格，根据规格id数组
     * @param $standardIds
     * @return mixed
     */
    public function getStandardByStandardIds ($standardIds)
    {
        $insertData = implode(',', $standardIds);

        $result = $this->where("standard_id IN ({$insertData})")->select();
        return $result;
    }

    /**
     * 获得规格，根据规格
     * @param $standardIds
     * @return mixed
     */
    public function getStandardByStandardId ($standardId)
    {
        $insertData = implode(',', $standardId);

        $result = $this->where("standard_id = ({$insertData})")->find();
        return $result;
    }
}