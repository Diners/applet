<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/28 0028
 * Time: 15:54
 */

namespace Home\Controller\Goods;

use Common\Controller\BaseController;
use Home\Model\GoodsCategoryModel;
use Home\Model\GoodsImageModel;
use Home\Model\GoodsModel;

class BrandGoodsListController extends BaseController
{
    // 品牌所有商品接口
    public function index()
    {
        $brandId = I('get.brand_id', 0, 'intval'); // 品牌id
        $categoryId = I('get.category_id', 1, 'intval'); // 分类id
        $page = I('get.page', 1, 'intval'); // 当前页数
        $pageSize = I('get.page_size', 10, 'intval'); // 每页显示条数

        if (!$brandId) {
            $errMessage = [
                'code' => 1,
                'message' => '品牌所有商品提交参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $categoryModel = new GoodsCategoryModel();
        $goodsModel = new GoodsModel();
        $goodsImage = new GoodsImageModel();

        $imageType = 1; // 首页图
        // 该品牌下的所有分类
        $categoryList = $categoryModel->getCategoryByBrand($brandId);

        // 该品牌下的所有商品
        $goodsList = $goodsModel->getGoodsByBrandId($brandId, $categoryId, $page, $pageSize);
        $goodCount = $goodsModel->getGoodsByBrandIdCount($brandId, $categoryId);

        $result = [];
        // 格式分类列表
        if ($categoryList) {
            foreach ($categoryList as $key => $val) {
                $result['category_list'][$key]['category_id'] = $val['cat_id'];
                $result['category_list'][$key]['category_name'] = $val['cat_name'];
            }
        }
        // 格式商品列表
        if ($goodsList) {
            foreach ($goodsList as $key => $val) {
                $result['goods_list'][$key]['goods_id'] = $val['goods_id'];
                $result['goods_list'][$key]['goods_name'] = $val['goods_name'];
                $result['goods_list'][$key]['goods_price'] = $val['goods_price'];
                $result['goods_list'][$key]['goods_thumb'] = $goodsImage->getGoodsImagesByType($val['goods_id'], $imageType)['thumb_url'];
            }
        }
        $result['page'] = $page;
        $result['page_size'] = $pageSize;
        $result['count'] = $goodCount;
        $this->ajaxReturn($result);
    }
}