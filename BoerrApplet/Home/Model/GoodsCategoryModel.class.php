<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:44
 */

namespace Home\Model;


use Common\Model\BaseModel;

class GoodsCategoryModel extends BaseModel
{
    /**
     * 根据品牌id获取该品牌下的所有分类
     * @param $brandId
     * @return mixed
     */
    public function getCategoryByBrand ($brandId)
    {
        $list = $this->where("brand_id = {$brandId} AND".STATUS)->select();
        return $list;
    }
}