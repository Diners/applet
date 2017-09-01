<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 13:38
 */

namespace UserAdmin\Model;

use Common\Model\BaseModel;

class GoodsBrandModel extends BaseModel
{
    // 根据品牌id获得品牌信息
    public function getBrand ($brandId)
    {
        $result = $this->where("brand_id = {$brandId} AND status < ".STATUS)->find();
        return $result;
    }
}