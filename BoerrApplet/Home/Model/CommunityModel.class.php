<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:39
 */

namespace Home\Model;

use Common\Model\BaseModel;

class CommunityModel extends BaseModel
{
    /**
     * 获得社群列表
     * @param $page int 当前页数
     * @param $pageSize int 每页条数
     * @return array
     */
    public function getCommunityList($page,$pageSize)
    {
        $communityList = $this->where(STATUS)->page($page, $pageSize)->select();
        return $communityList;
    }

    /**
     * 获得社群总数
     * @return mixed
     */
    public function getCommunityCount () {
        $communityCount = $this->where(STATUS)->count();
        return $communityCount;

    }
    /**
     * 根据社区id获得该社群信息
     * @param $communityId int 社群id
     * @return array
     */
    public function getCommunityMessageOne ($communityId)
    {
        $community = $this->where("community_id = {$communityId} AND".STATUS)->find();
        return $community;
    }
}