<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/11 0011
 * Time: 9:34
 */

namespace Home\Controller\Login;

use Common\Controller\BaseController;
use Home\Model\AdminModel;

class LoginController extends BaseController
{
    // 后台登陆接口
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');

        $adminName = I('post.admin_name', '', 'trim');
        $adminPassword = I('post.admin_password', '', 'trim');

        if (!$adminName || !$adminPassword) {
            $errMessage = [
                'code' => 1,
                'message' => '登陆参数不能为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $md5Password = md5($adminPassword);
        $adminModel = new AdminModel();
        // 获得用户信息
        $adminInfo = $adminModel->getAdminInfo($adminName, $md5Password);
        if (!$adminInfo) {
            $errMessage = [
                'code' => 2,
                'message' => '管理员不存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $result['admin_id'] = $adminInfo['admin_id'];
        $result['admin_name'] = $adminInfo['admin_name'];
        $result['brand_id'] = $adminInfo['brand_id'];
        $this->ajaxReturn($result);

    }
}