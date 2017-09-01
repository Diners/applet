<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:04
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\CommunityArticleImageModel;
use Home\Model\CommunityModel;
use Home\Model\CommunityArticleModel;

class CommunityIndexController extends BaseController
{
    /**
     * 社群首页
     */
    public function index ()
    {
        $page = I('get.page', 1, 'intval'); // 当前页数
        $pageSize = I('get.page_size', 10, 'intval'); // 每页显示条数

        // 实例化
        $communityModel = new CommunityModel();
        $communityArticleModel = new CommunityArticleModel();
        $communityImageModel = new CommunityArticleImageModel();

        // 社群列表
        $community = $communityModel->getCommunityList($page, $pageSize);
        // 社群列表id
        $ids = array_column($community, 'community_id');
        if (!$community) {
            $errMessage = [
                'code' => 1,
                'message' => '还没有创建任何一个社群！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        // 社群文章列表
        $communityList = $communityArticleModel->getAllArticle($ids);

        // 返回结果
        $result = [];
        // 格式化返回数组
        foreach ($community as $key => $val) {
            $result['community_list'][$key]['id'] = $val['community_id'];
            $result['community_list'][$key]['title'] = $val['community_title'];
            $result['community_list'][$key]['img'] = $val['community_img'];
            $result['community_list'][$key]['attention'] = $val['community_attention'];
            foreach ($communityList as $k => $v) {
                if ($val['community_id'] == $v['community_id']) {
                    $result['community_list'][$key]['article_list'][$k]['article_id'] = $v['article_id'];
                    // 获得文章图片
                    $result['community_list'][$key]['article_list'][$k]['article_img'] = $communityImageModel->getImage($v['article_id']);
                }
            }
            $result['community_list'][$key]['article_list'] = array_slice($result['community_list'][$key]['article_list'],2);
        }

        foreach ($result['community_list'] as $k => $v) {
            $result['community_list'][$k]['article_list'] = array_slice($v['article_list'],0, 3);
        }
        $result['page'] = $page;
        $result['page_size'] = $pageSize;
        $result['count'] = (int)$communityModel->getCommunityCount();
        $this->ajaxReturn($result);
        return true;
    }
}