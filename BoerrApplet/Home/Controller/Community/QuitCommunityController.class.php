<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/25 0025
 * Time: 20:21
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\CommunityJoinModel;

class QuitCommunityController extends BaseController
{
    // 退出社群
    public function index ()
    {
        $userId = I('post.user_id', 0 ,'intval');
        $communityId = I('post.community_id', 0, 'intval');

        if (!$userId || !$communityId) {
            $errMessage = [
                'code' => 1,
                'message' => '退出社群接口参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $joinModel = new CommunityJoinModel();
        $result = $joinModel->communityQuit($userId, $communityId);
        if (!$result) {
            $errMessage = [
                'code' => 1,
                'message' => '退出社群失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        } else {
            $this->ajaxReturn(['type' => 0]);
            return true;
        }
    }
}