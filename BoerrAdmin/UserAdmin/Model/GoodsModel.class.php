<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/12 0012
 * Time: 15:14
 */

namespace UserAdmin\Model;

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

    // 根据品牌id获得商品列表
    public function getGoodsByBrandId ($brandId)
    {
        $result = $this->where("brand_id = {$brandId} AND status < ".STATUS)->select();
        return $result;
    }

    // 根据品牌id获得商品列表,带分页
    public function getGoodsByBrandIdPage ($brandId, $page, $pageSize)
    {
        $result = $this->where("brand_id = {$brandId} AND status < ".STATUS)->page($page, $pageSize)->select();
        return $result;
    }

    // 根据品牌id获得商品总数
    public function getGoodsByBrandIdCount ($brandId)
    {
        $result = $this->where("brand_id = {$brandId} AND status < ".STATUS)->count();
        return $result;
    }

    // 保存商品信息
    public function saveGoods ($goodsId, $saveData)
    {
        $result = $this->where("goods_id = {$goodsId} status < ".STATUS)->save($saveData);
        return $result;
    }

}