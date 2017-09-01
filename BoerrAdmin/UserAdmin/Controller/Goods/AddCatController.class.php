<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 15:26
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsCategoryModel;

class AddCatController extends BaseController
{
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $catName = I('post.cat_name', '', 'trim');
        $brandId = I('post.brand_id', 0, 'trim');
        if (!$catName) {
            $this->ajaxReturn('分类id不能为空！');
        }

        $catModel = new GoodsCategoryModel();
        // 插入数据
        $addData = [
            'cat_name' => $catName,
            'brand_id' => $brandId,
            'status' => 1,
            'created' => time(),
        ];
        // 添加分类
        $result = $catModel->addCat ($addData);
        if (!$result) {
            $this->ajaxReturn('添加分类失败！');
        }
        $this->ajaxReturn('true');
    }
}