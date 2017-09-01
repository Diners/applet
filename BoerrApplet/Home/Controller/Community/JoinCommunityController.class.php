<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/22 0022
 * Time: 14:09
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\CommunityJoinModel;

class JoinCommunityController extends BaseController
{
    // 加入社群
    public function index()
    {
        $userId = I('post.user_id', 0 ,'intval');
        $communityId = I('post.community_id', 0, 'intval');

        if (!$userId || !$communityId) {
            $errMessage = [
                'code' => 1,
                'message' => '加入社群接口参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $joinModel = new CommunityJoinModel();
        // 加入社群
        $result = $joinModel->communityJoin($userId, $communityId);
        if (!$result) {
            $errMessage = [
                'code' => 1,
                'message' => '加入社群失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        } else {
            $this->ajaxReturn(['type' => 1]);
            return true;
        }
    }
}