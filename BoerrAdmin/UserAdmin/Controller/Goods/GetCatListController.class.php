<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 14:24
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsCategoryModel;

class GetCatListController extends BaseController
{
    // 获得分类接口
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $brandId = I('get.brand_id', 0, 'intval');
        if (!$brandId) {
            $this->ajaxReturn('品牌id不能为空');
        }

        $goodsCatModel = new GoodsCategoryModel();
        $catList = $goodsCatModel->getCatByBrandId ($brandId);

        $result = [];
        foreach ($catList as $key => $val) {
            $result['cat_list'][$key]['cat_id'] = $val['cat_id'];
            $result['cat_list'][$key]['cat_name'] = $val['cat_name'];
        }
        $this->ajaxReturn($result);
        return true;
    }
}