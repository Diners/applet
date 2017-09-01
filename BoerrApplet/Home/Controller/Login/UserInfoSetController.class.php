<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/21 0021
 * Time: 15:49
 */

namespace Home\Controller\Login;

use Common\Controller\BaseController;
use Common\Model\BaseModel;
use Home\Model\BankModel;
use Home\Model\UserModel;

class UserInfoSetController extends BaseController
{
    public function index ()
    {
        $userName = I('post.user_name'); // 用户姓名
        $openId = I('post.openid', '', 'string'); // openid
        $sex = I('post.sex', 0, 'intval'); // 用户性别
        $userHead = I('post.user_head', '', 'trim'); // 用户头像
        $userAddr = I('post.user_addr', '', 'trim'); // 用户地址

        // 判断用户信息
        if (!$userName || !$openId || !$sex || !$userHead || !$userAddr) {
            $errMessage = [
                'code' => 1,
                'message' => '用户信息不能为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $bankModel = new BankModel();
        $userModel = new UserModel();
        // 获得用户信息
        $userInfo = $userModel->getUserByOpenId($openId);


        $realSex = 0;
        // 男性为0，女性为1
        if ($sex == 1) {
            $realSex = 0;
        } else {
            $realSex = 1;
        }
        // 如果不存在 插入用户信息
        if (!$userInfo) {
            $data = [
                'user_name' => $userName,
                'openid' => $openId,
                'user_sex' => $realSex,
                'user_head' => $userHead,
                'user_addr' => $userAddr
            ];
            $userId = $userModel->setUserInfo($data);
            // 获得bank表记录，如果没有插入
            $bankInfo = $bankModel->getBank($userId);
            if (!$bankInfo) {
                $insertData = [
                    'user_id' => $userId,
                    'update' => time()
                ];
                $bankId = $bankModel->insertBank($insertData);
                if (!$bankId) {
                    $errMessage = [
                        'code' => 3,
                        'message' => '插入bank表失败！'
                    ];
                    $this->ajaxReturn($errMessage);
                    return false;
                }
            }
            if (!$userId) {
                $errMessage = [
                    'code' => 1,
                    'message' => '插入用户信息失败！'
                ];
                $this->ajaxReturn($errMessage);
                return false;
            } else {
                $result = [];
                $result['user_message']['user_id'] = $userId;
                $result['user_message']['user_name'] = $userName;
                $result['user_message']['openid'] = $openId;
                $result['user_message']['user_sex'] = $sex;
                $result['user_message']['user_mobile'] = $userHead;
                $result['user_message']['user_head'] = $userAddr;
                $this->ajaxReturn($result);
            }
        }

    }
}