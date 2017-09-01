<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 10:27
 */

namespace UserAdmin\Model;

use Common\Model\BaseModel;

class GoodsCategoryModel extends BaseModel
{
    // 根据分类id获取分类信息
    public function getCategory ($catId)
    {
        $result = $this->where("cat_id = {$catId}")->find();
        return $result;
    }

    // 根据分类id获得品牌列表
    public function getCatByBrandId ($brandId)
    {
        $result = $this->where("brand_id = {$brandId} AND status < ".STATUS)->select();
        return $result;
    }

    // 添加分类
    public function addCat ($addData)
    {
        $result = $this->add($addData);
        return $result;
    }

    // 根据分类状态更新
    public function UpdateCat ($catId, $data)
    {
        $result = $this->where("cat_id = {$catId}")->save($data);
        return $result;
    }
}