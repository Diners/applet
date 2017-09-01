<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/20 0020
 * Time: 21:24
 */

namespace Home\Model;

use Common\Model\BaseModel;

class GoodsImageModel extends BaseModel
{

    /**
     * 获得商品图片
     * @param $goodsId
     * @return bool|mixed
     */
    public function getGoodsImages ($goodsId, $imageType) {
        if (!$goodsId) {
            \Think\Log::write('商品图片model传入id不能为空！');
            return false;
        }
        $list = $this->where("goods_id = {$goodsId} AND img_type = ".$imageType)->select();
        return $list;
    }

    public function getGoodsImagesByType ($goodsId, $type)
    {
        $list = $this->where("goods_id = {$goodsId} AND img_type = {$type}")->find();
        return $list;
    }
}