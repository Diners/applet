<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/25 0025
 * Time: 19:57
 */

namespace Home\Model;

use Common\Model\BaseModel;

class CommunityJoinModel extends BaseModel
{
    /**
     * 加入社群
     * @param $userId
     * @param $articleId
     * @return bool|mixed
     */
    public function communityJoin ($userId, $communityId)
    {
        $find = $this->where("user_id = {$userId} AND community_id = {$communityId}")->find();

        if ($find) {
            $data = [
                'join_type' => JOIN_STATUS
            ];
            $result = $this->where("community_id = {$communityId} AND user_id = {$userId}")->save($data);
            return $result;
        } else {
            $data = [
                'user_id' => $userId,
                'community_id' => $communityId,
                'join_type' => JOIN_STATUS
            ];
            $result = $this->add($data);
            return $result;
        }
    }

    /**
     * 退出社群
     * @param $userId
     * @param $communityId
     * @return bool|mixed
     */
    public function communityQuit ($userId,$communityId)
    {
        $find = $this->where("user_id = {$userId} AND community_id = {$communityId}")->find();

        if ($find) {
            $data = [
                'join_type' => CANCEL_JOIN_STATUS
            ];
            $result = $this->where("community_id = {$communityId} AND user_id = {$userId}")->save($data);
            return $result;
        } else {
            // 还未加入该社群
            return false;
        }
    }

    /**
     * 获取用户加入社群信息
     * @param $userId
     * @param $communityId
     * @return mixed
     */
    public function getJoinMessage ($userId,$communityId)
    {
        $find = $this->where("user_id = {$userId} AND community_id = {$communityId}")->find();

        return $find;
    }
}