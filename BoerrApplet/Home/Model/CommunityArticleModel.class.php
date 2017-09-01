<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:41
 */

namespace Home\Model;


use Common\Model\BaseModel;

class CommunityArticleModel extends BaseModel
{
    /**
     * 获得文章
     */
    public function getArticles ($ids)
    {
        if (!is_array($ids)) {
            \Think\Log::write('获得文章model传入id必须为数组格式');
            return false;
        }
        $idStr = implode(',', $ids);
        $list = $this->where("community_id IN ({$idStr}) AND".STATUS)->limit(3)->select();
        return $list;
    }

    /**
     * 根据社群id获得文章列表
     * @param $id
     * @param $page
     * @param $pageSize
     * @return bool|mixed
     */

    public function getArticleList($id)
    {
        if (!$id) {
            \Think\Log::write('获得文章model传入id不能为空！');
            return false;
        }
        $list = $this->where("community_id = {$id} AND".STATUS)->order('created DESC')->select();
        return $list;
    }

    /**
     * 获得社群文章总数
     * @param $communityId int 社群id
     * @return int 文章总数
     */
    public function getArticleCount ($communityId)
    {
        if (!$communityId) {
            \Think\Log::write('获得文章总数传入id不能为空！');
            return false;
        }
        $count = $this->where("community_id = {$communityId}")->count();
        return $count;
    }

    /**
     * 添加文章
     * @param $communityId int 社群id
     * @param $userId int 用户id
     * @param $articleDesc string 文章详情
     * @return int 插入文章id
     */
    public function addArticle($communityId, $userId, $articleDesc)
    {
        $data = [
            'user_id' => $userId,
            'community_id' => $communityId,
            'article_desc' => $articleDesc,
            'status' => 0,
            'created' => time(),
        ];
        return $this->add($data);
    }

    /**
     * 获得所有文章
     * @param $ids
     * @return bool|mixed
     */
    public function getAllArticle ($ids)
    {
        if (!is_array($ids)) {
            \Think\Log::write('获得文章model传入id必须为数组格式');
            return false;
        }
        $idStr = implode(',', $ids);
        $list = $this->where("community_id IN ({$idStr}) AND".STATUS)->select();
        return $list;
    }

    /**
     * 文章点赞数自加1
     * @param $articleId
     */
    public function setLikeCount ($articleId)
    {
        $likeCount = $this->where("article_id = {$articleId}")->find()['like'];
        $saveData = [
            'like' => $likeCount + 1
        ];
        $result = $this->where("article_id = {$articleId}")->save($saveData);
        return $result;
    }
}