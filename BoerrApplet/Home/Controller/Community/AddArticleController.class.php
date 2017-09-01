<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/19 0019
 * Time: 17:48
 */

namespace Home\Controller\Community;


use Common\Controller\BaseController;
use Home\Model\CommunityArticleImageModel;
use Home\Model\CommunityArticleModel;
use Think\Upload;

class AddArticleController extends BaseController
{
    /**
     * 添加文章
     */
    public function index ()
    {
        $communityId = I('post.community_id', 0, 'intval');
        $userId = I('post.user_id', 0, 'intval');
        $articleDesc = I('post.article_desc', '', 'trim');

        // 如果参数为空
        if (!$communityId || !$userId || !$articleDesc) {
            $errMessage = [
                'code' => 1,
                'message' => '添加文章参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $communityArticleModel = new CommunityArticleModel();
        // 文章id
        $articleId = $communityArticleModel->addArticle($communityId, $userId, $articleDesc);
        // 如果添加文章失败
        if (!$articleId) {
            $errMessage = [
                'code' => 1,
                'message' => '添加文章失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        } else {
            // 返回文章id
            $this->ajaxReturn(['article_id' => $articleId]);
            return true;
        }
    }
}