<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:47
 */

namespace Home\Model;


use Common\Model\BaseModel;

class UserModel extends BaseModel
{
    /**
     * 根据openid获取用户信息
     * @param $openId
     * @return bool|mixed
     */
    public function getUserByOpenId ($openId)
    {
        if (!$openId) {
            \Think\Log::write('userModel openid不能为空！');
            return false;
        }
        $user = $this->where("openId = '{$openId}' AND".STATUS)->find();
        return $user;
    }

    /**
     * 根据user_id获取用户信息
     * @param $userId
     * @return bool|mixed
     */
    public function getUserByUserId ($userId)
    {
        if (!$userId) {
            \Think\Log::write('userModel user_id不能为空！');
            return false;
        }
        $user = $this->where("user_id = '{$userId}' AND".STATUS)->find();
        return $user;
    }

    /**
     * 修改用户信息
     * @param $userId
     * @param $data
     * @return bool
     */
    public function setUserBuUserId ($userId, $data) {

        if (!is_array($data)) {
            \Think\Log::write('userModel 修改个人信息参数必须为数组！');
            return false;
        }

        $user = $this->where("user_id = {$userId} AND".STATUS)->save($data);

        return $user;
    }

    /**
     * 添加新用户
     * @param $userData
     * @return bool|mixed
     */
    public function setUserInfo ($userData)
    {
        $userInfo = $this->where("openid = '{$userData['openid']}' AND".STATUS)->find();
        if ($userInfo) {
            \Think\Log::write('userModel 用户信息已经存在，不能重复添加！');
            return false;
        }
        $userData['created'] = time();
        $result = $this->add($userData);
        return $result;
    }
}