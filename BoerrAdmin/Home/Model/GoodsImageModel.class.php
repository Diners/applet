<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/12 0012
 * Time: 15:22
 */

namespace Home\Model;

use Common\Model\BaseModel;

class GoodsImageModel extends BaseModel
{
    // 添加多张图片
    public function addGoodsImages ($imageUrls)
    {
        $result = $this->addAll($imageUrls);
        return $result;
    }

    // 添加一张图片
    public function addGoodsImage ($imageUrl)
    {
        $result = $this->add($imageUrl);
        return $result;
    }

    // 根据商品id获得图片
    public function getGoodsImages ($goodsId)
    {
        $result = $this->where("goods_id = {$goodsId}")->select();
        return $result;
    }
}