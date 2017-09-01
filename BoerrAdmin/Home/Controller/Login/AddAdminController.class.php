<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/11 0011
 * Time: 11:16
 */

namespace Home\Controller\Login;

use Common\Controller\BaseController;
use Home\Model\AdminModel;

class AddAdminController extends BaseController
{
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
//        // 响应类型
//        header('Access-Control-Allow-Methods:POST');
//        // 响应头设置
//        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $adminName = I('post.admin_name', '', 'trim');
        $adminPassword = I('post.admin_password', '', 'trim');
        $brandId = I('post.brand_id', 0, 'intval');

        if (!$adminName || !$adminPassword) {
            $errMessage = [
                'code' => 1,
                'message' => '提交参数不能为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $md5Password = md5($adminPassword);
        $adminModel = new AdminModel();
        $info = $adminModel->getAdminInfo($adminName);
        if ($info) {
            $errMessage = [
                'code' => 2,
                'message' => '该用户已经存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        } else {
            $result = $adminModel->setAdmin($adminName, $md5Password, $brandId);
            $this->ajaxReturn($result);
        }

    }
}