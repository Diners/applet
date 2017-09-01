<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 10:27
 */

namespace Home\Model;

use Common\Model\BaseModel;

class GoodsCategoryModel extends BaseModel
{
    // 根据分类id获取分类信息
    public function getCategory ($catId)
    {
        $result = $this->where("cat_id = {$catId}")->find();
        return $result;
    }
}