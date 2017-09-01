<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:41
 */

namespace Home\Model;


use Common\Model\BaseModel;
use Home\Controller\SearchController;

class CommunityArticleLikeModel extends BaseModel
{
    /**
     * 点赞
     * @param $articleId
     * @param $userId
     * @param $likeType
     * @return mixed
     */
    public function setLike ($articleId, $userId)
    {
        if (!$articleId || !$userId) {
            \Think\Log::write('文章点赞model参数不能为空！');
            return flase;
        }
        $find = $this->where("article_id = {$articleId} AND user_id = {$userId}")->find();
        // 判断点赞记录是否存在，不存在创建
        if ($find) {
            $data = [
                'like_type' => LIKE_STATUS
            ];
            $result = $this->where("article_id = {$articleId} AND user_id = {$userId}")->save($data);
            return $result;
        } else {
            $data = [
                'user_id' => $userId,
                'article_id' => $articleId,
                'like_type' => LIKE_STATUS
            ];
            $result = $this->add($data);
            return $result;
        }

    }

    /**
     * 社群文章取消点赞
     * @param $articleId
     * @param $userId
     * @return bool|mixed
     */
    public function cancelLike ($articleId, $userId)
    {
        if (!$articleId || !$userId) {
            \Think\Log::write('文章点赞model参数不能为空！');
            return flase;
        }
        $find = $this->where("article_id = {$articleId} AND user_id = {$userId}")->find();
        // 判断点赞记录是否存在，不存在创建
        if ($find) {
            $data = [

                'like_type' => CANCEL_LIKE_STATUS
            ];
            $result = $this->where("article_id = {$articleId} AND user_id = {$userId}")->save($data);
            return $result;
        } else {
            // 还未点赞，不能取消点赞
            return false;
        }
    }
}