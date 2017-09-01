<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/22 0022
 * Time: 14:07
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\CommunityArticleLikeModel;
use Common\Model\BaseModel;

class ArticleCancelLikeController extends BaseController
{
    public function index ()
    {
        $userId = I('post.user_id', 0, 'intval'); // 用户id
        $articleId = I('post.article_id', 0, 'intval'); // 文章id

        if (!$userId || !$articleId) {
            $errMessage = [
                'code' => 1,
                'message' => '取消点赞接口参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $articleModel = new CommunityArticleLikeModel();

        // 点赞
        $result = $articleModel->cancelLike($articleId, $userId);

        if (!$result) {
            $errMessage = [
                'code' => 1,
                'message' => '取消点赞失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        } else {
            $this->ajaxReturn('true');
            return true;
        }
    }
}