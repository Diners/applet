<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/22 0022
 * Time: 14:03
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\CommunityArticleLikeModel;
use Common\Model\BaseModel;
use Home\Model\CommunityArticleModel;

class ArticleLikeController extends BaseController
{
    // 文章点赞
    public function index ()
    {
        $userId = I('post.user_id', 0, 'intval');
        $articleId = I('post.article_id', 0, 'intval');

        if (!$userId || !$articleId) {
            $errMessage = [
                'code' => 1,
                'message' => '点赞接口参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $articleModel = new CommunityArticleLikeModel();
        $artModel = new CommunityArticleModel();
        // 点赞
        $result = $articleModel->setLike($articleId, $userId);
        // 点赞数加1
        $artModel->setLikeCount($articleId);
        if (!$result) {
            $errMessage = [
                'code' => 1,
                'message' => '点赞失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        } else {
            $this->ajaxReturn('true');
            return true;
        }

    }
}