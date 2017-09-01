<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 15:39
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsCategoryModel;

class DeleteCatController extends BaseController
{
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $catId = I('post.cat_id', 0 ,'intval');
        if (!$catId) {
            $this->ajaxReturn('分类id不能为空！');
        }
        $catModel = new GoodsCategoryModel();
        // 删除分类
        $deleteData = [
            'status' => 3,
        ];
        $result = $catModel->UpdateCat ($catId, $deleteData);
        if (!$result) {
            $this->ajaxReturn('添加分类失败！');
        }
        $this->ajaxReturn('true');
    }
}