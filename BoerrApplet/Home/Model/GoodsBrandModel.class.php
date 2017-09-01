<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:44
 */

namespace Home\Model;


use Common\Model\BaseModel;

class GoodsBrandModel extends BaseModel
{
    /**
     * 获取品牌列表
     * @param $goodsIds
     * @return mixed
     */
    public function getBrand($brandIds, $page, $pageSize)
    {
        $idStr = implode(',', $brandIds);
        $list = $this->where("brand_id IN ({$idStr}) AND" . STATUS)->page($page, $pageSize)->select();
        return $list;
    }

    /**
     * 获得品牌总数
     * @param $goodsIds
     * @return mixed
     */

    public function getBrandCount($goodsIds)
    {
        $idStr = implode(',', $goodsIds);
        $count = $this->where("goods_id IN ({$idStr}) AND" . STATUS)->group('brand_name')->count();
        return $count;
    }


    /**
     * 根据品牌id获得品牌详情
     * @param $brandId
     */
    public function getBrandOne($brandId)
    {
        $result = $this->where("brand_id = {$brandId}")->find();

        return $result;
    }
}