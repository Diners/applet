<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/19 0019
 * Time: 17:54
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\CommunityModel;
use Home\Model\GoodsBrandModel;
use Home\Model\GoodsImageModel;
use Home\Model\GoodsModel;

class AdviceListController extends BaseController
{
    public function index ()
    {
        $page = I('get.page', 1, 'intval'); // 当前页数
        $pageSize = I('get.page_size', 10, 'intval'); // 每页显示条数
        $communityId = I('get.community_id', 0, 'intval');
        if (!$communityId) {
            $errMessage = [
                'code' => 1,
                'message' => '社群id为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $communityModel = new CommunityModel();
        $goodsModel = new GoodsModel();
        $goodsBrand = new GoodsBrandModel();
        $goodsImage = new GoodsImageModel();

        // 获得推荐商品列表
        $message = $communityModel->getCommunityMessageOne($communityId);
        $adviceIds = unserialize($message['goods_suggest']);
        //如果推荐列表不存在
        if (!$adviceIds) {
            $errMessage = [
                'code' => 1,
                'message' => '推荐列表为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $goodsList = $goodsModel->getGoodsList($adviceIds);

        // 商品id数组
        $goodsIds = array_column($goodsList, 'goods_id');
        $goodsIds = array_unique($goodsIds);
        if (!$goodsIds) {
            $errMessage = [
                'code' => 1,
                'message' => '获取商品id失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $brandIds = $goodsModel->getBrandByGoodsId($goodsIds, $page, $pageSize);

        $brandIds = array_column($brandIds, 'brand_id');
        $brandIds = array_unique($brandIds);
        $brandList = $goodsBrand->getBrand($brandIds, $page, $pageSize);
        $imageType = 1; // 首页图
        $result = [];
        // 格式数组
        foreach ($brandList as $key => $val) {
            $result['brand_list'][$key]['brand_id'] = $val['brand_id'];
            $result['brand_list'][$key]['brand_name'] = $val['brand_name'];
            $result['brand_list'][$key]['brand_logo'] = $val['brand_logo'];
            $result['brand_list'][$key]['brand_introd'] = $val['brand_introd'];
            foreach ($goodsList as $k => $v) {
                if ($v['brand_id'] = $val['brand_id']) {
                    $result['brand_list'][$key]['goods_list'][$k]['goods_id'] = $v['goods_id'];
                    $result['brand_list'][$key]['goods_list'][$k]['category_id'] = $v['cat_id'];
                    $result['brand_list'][$key]['goods_list'][$k]['goods_name'] = $v['goods_name'];
                    $result['brand_list'][$key]['goods_list'][$k]['goods_price'] = $v['goods_price'];
                    $result['brand_list'][$key]['goods_list'][$k]['goods_thumb'] = $goodsImage->getGoodsImagesByType($v['goods_id'], $imageType)['thumb_url'];
                }
            }
        }
        $result['page'] = $page;
        $result['page_size'] = $pageSize;
        $result['count'] = (int)$goodsBrand->getBrandCount($brandIds);
        $this->ajaxReturn($result);
        return true;
    }
}