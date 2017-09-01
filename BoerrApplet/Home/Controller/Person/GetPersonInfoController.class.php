<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 9:38
 */

namespace Home\Controller\Person;

use Common\Controller\BaseController;
use Home\Model\UserModel;

class GetPersonInfoController extends BaseController
{
    /**
     * 获取个人信息
     */
    public function index ()
    {
        $userId = I('get.user_id', 0, 'intval');

        // user_id 不能为空
        if (!$userId) {
            $errMessage = [
                'code' => 1,
                'message' => 'user_id不能为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $userModel = new UserModel();

        // 用户基础信息
        $userInfo = $userModel->getUserByUserId($userId);

        // 返回信息
        $result = [];
        $result['user_id'] = $userInfo['user_id'];
        $result['user_name'] = $userInfo['user_name'];
        $result['openid'] = $userInfo['openid'];
        $result['user_sex'] = $userInfo['user_sex'];
        $result['user_mobile'] = $userInfo['user_telephone'];
        $result['user_head'] = $userInfo['user_head'];
        $result['user_diy'] = $userInfo['user_diy'];
        $result['user_addr'] = $userInfo['user_addr'];
        $this->ajaxReturn($result);
        return true;

    }
}