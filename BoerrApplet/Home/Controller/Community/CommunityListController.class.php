<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 18:12
 */
namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\CommunityArticleImageModel;
use Home\Model\CommunityArticleLikeModel;
use Home\Model\CommunityJoinModel;
use Home\Model\CommunityModel;
use Home\Model\CommunityArticleModel;
use Home\Model\UserModel;

class CommunityListController extends BaseController
{
    /**
     * 社群列表
     */
    public function index ()
    {
//        $page = I('get.page', 1, 'intval'); // 当前页数
//        $pageSize = I('get.page_size', 10, 'intval'); // 每页显示条数
        $communityId = I('get.community_id', 0, 'intval'); // 社群id
        $userId = I('get.user_id', 0, 'intval'); // 用户id

        // 社群id不能为空
        if (!$communityId || !$userId) {
            $this->ajaxReturn(['code' => 2, 'message' => '提交参数不能为空！']);
        }

        $communityModel = new CommunityModel();
        $communityImageModel = new CommunityArticleImageModel();
        $articleModel = new CommunityArticleModel();
        $userModel = new UserModel();
        $articleLikeModel = new CommunityArticleLikeModel();
        $joinModel = new CommunityJoinModel();
        // 获得社群信息
        $message = $communityModel->getCommunityMessageOne($communityId);
        if (!$message) {
            $this->ajaxReturn(['code' => 2, 'message' => '社群不存在！']);
        }
        // 获得文章列表
        $articleList = $articleModel->getArticleList($communityId);

        // 获得用户加入社群信息
        $joinList = $joinModel->getJoinMessage($userId, $communityId);

        $result = [];
        if (!$joinList['join_type']) {
            $joinList['join_type'] = 0;
        }
        $result['community_message'] = [
            'title' => $message['community_title'],
            'img' => $message['community_img'],
            'desc' => $message['community_desc'],
            'join_type' => $joinList['join_type']
        ];

        // 格式返回值
        foreach ($articleList as $key => $val) {
            // 获得用户信息
            $userMessage = $userModel->where("user_id = {$val['user_id']} AND".STATUS)->find();
            $result['article_list'][$key]['user_id'] = $userMessage['user_id'];
            $result['article_list'][$key]['user_name'] = $userMessage['user_name'];
            $result['article_list'][$key]['user_head'] = $userMessage['user_head'];
            $result['article_list'][$key]['like_type'] = $articleLikeModel->where("user_id = {$userId} AND article_id = '{$val['article_id']}'")->find()['like_type'] == 1 ? 1 : 0;
            $str = mb_substr($val['article_desc'],0,50,'utf-8');
            $result['article_list'][$key]['article_id'] = $val['article_id'];
            $result['article_list'][$key]['article_images'] = array_column($communityImageModel->getImages($val['article_id']), 'thumb_url');
            $result['article_list'][$key]['article_content'] = $val['article_desc'];
            $result['article_list'][$key]['article_part'] = $str;
            $result['article_list'][$key]['like_count'] = $val['like'];
            $result['article_list'][$key]['created_time'] = $this->__timeTrain($val['created']);
        };
//        $result['page'] = $page;
//        $result['page_size'] = $pageSize;
//        $result['count'] = (int)$articleModel->getArticleCount($communityId);
        $this->ajaxReturn($result);

        return true;
    }

    /**
     * 获得当前时间
     * @param $the_time string 文章创建时间
     * @return string 当前时间
     */
    public function __timeTrain ($the_time)
    {
        $dur = time() - $the_time;
        if ($dur < 0) {
            return $the_time;
        } else {
            if ($dur < 60) {
                return $dur . '秒前';
            } else {
                if ($dur < 3600) {
                    return floor($dur / 60) . '分钟前';
                } else {
                    if ($dur < 86400) {
                        return floor($dur / 3600) . '小时前';
                    } else {
                        if ($dur < 604800) {//7天内
                            return floor($dur / 86400) . '天前';
                        } else {
                            if ($dur < 2419200) { // 一个月
                                return floor($dur / 604800) . '周前';
                            } else {
                                return date("Y-m-d H:i",$the_time);
                            }

                        }
                    }
                }
            }
        }
    }
}