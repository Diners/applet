<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 18:01
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsBrandModel;
use UserAdmin\Model\GoodsCategoryModel;
use UserAdmin\Model\GoodsImageModel;
use UserAdmin\Model\GoodsModel;
use UserAdmin\Model\GoodsStandardModel;

class GoodsOutSaleListController extends BaseController
{
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $page = I('get.page');
        $pageSize = I('get.page_size');
        $brandId = I('get.brand_id', 0, 'intval');

        if (!$brandId) {
            $this->ajaxReturn('品牌id不能为空');
        }

        $goodsModel = new GoodsModel();
        $goodsImageModel = new GoodsImageModel();
        $goodsStandardModel = new GoodsStandardModel();
        $goodsCategoryModel = new GoodsCategoryModel();
        $goodsBrandModel = new GoodsBrandModel();
        $result = [];

        if ($page && $pageSize) {
            // 获得商品信息
            $goodsInfo = $goodsModel->getGoodsByBrandIdPage ($brandId, $page, $pageSize);
            $Count = $goodsModel->getGoodsByBrandIdCount($brandId);
            $goodsCount = ceil($Count/$pageSize);
            $result['page'] = $page;
            $result['page_size'] = $pageSize;
            $result['page_count'] = $goodsCount;
        } else {
            $goodsInfo = $goodsModel->getGoodsByBrandId ($brandId);
        }
        // 格式返回数组

        foreach ($goodsInfo as $key =>$val) {
            $standardList = $goodsStandardModel->getStandards($val['goods_id']);
            foreach ($standardList as $k => $v) {
                unset($standardList[$k]['goods_id']);
                unset($standardList[$k]['standard_image']);
                unset($standardList[$k]['sell_num']);
                unset($standardList[$k]['status']);
                unset($standardList[$k]['created']);
                unset($standardList[$k]['delete']);
            }
            // 获得一张商品图片
            $goodsImageInfo = $goodsImageModel->getGoodsImage($val['goods_id']);
            $result['goods_list'][$key]['goods_id'] = $val['goods_id'];
            $result['goods_list'][$key]['goods_name'] = $val['goods_name'];
            $result['goods_list'][$key]['publish_user'] = $goodsBrandModel->getBrand($val['brand_id'])['brand_name'];
            $result['goods_list'][$key]['cat_name'] = $goodsCategoryModel->getCategory($val['cat_id'])['cat_name'];
            $result['goods_list'][$key]['goods_thumb_url'] = $goodsImageInfo['thumb_url'];
            $result['goods_list'][$key]['created_time'] = date("Y-m-d H:i:s",$val['created']);;
            $result['goods_list'][$key]['standard_list'] = $standardList;
        }
        $this->ajaxReturn($result);
        return true;
    }
}