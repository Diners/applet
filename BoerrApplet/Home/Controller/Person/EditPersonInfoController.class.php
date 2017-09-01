<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 9:40
 */

namespace Home\Controller\Person;

use Common\Controller\BaseController;
use Home\Model\UserModel;

class EditPersonInfoController extends BaseController
{
    /**
     * 编辑个人信息
     */
    public function index()
    {
        $userId = I('post.user_id', 0, 'intval');
        $userName = I('post.user_name', '', 'trim');
        $userSex = I('post.user_sex');
        $userHead = I('post.user_head', '', 'trim');
        $userAddr = I('post.user_addr', '', 'trim');
        $userdiy = I('post.user_diy', '', 'trim');

        if (!$userId) {
            $errMessage = [
                'code' => 1,
                'message' => 'user_id不能为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $data = [];
        // 参数赋值
        if ($userName) {
            $data['user_name'] = $userName;
        }
        if ($userHead) {
            $data['user_head'] = $userHead;
        }
        if ($userAddr) {
            $data['user_addr'] = $userAddr;
        }
        if ($userdiy) {
            $data['user_diy'] = $userdiy;
        }
        if ($userSex == 0) {
            $data['user_sex'] = 0;
        } elseif ($userSex == 1) {
            $data['user_sex'] = 1;
        }

        $userModel = new UserModel();
        $userModel->setUserBuUserId($userId, $data);

        // 判断修改
        $userInfo = $userModel->getUserByUserId($userId);
        $result = [];
        $result['user_id'] = $userInfo['user_id'];
        $result['user_name'] = $userInfo['user_name'];
        $result['user_sex'] = $userInfo['user_sex'];
        $result['user_mobile'] = $userInfo['user_telephone'];
        $result['user_head'] = $userInfo['user_head'];
        $result['user_diy'] = $userInfo['user_diy'];
        $this->ajaxReturn($result);
        return true;

    }
}