<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/10 0010
 * Time: 17:07
 */

namespace Home\Controller\Goods;

use Common\Controller\BaseController;

class GoodsLstController extends BaseController
{
    // 添加商品
    public function index ()
    {
        $brandId = I('get.brand_id', 0, 'intval'); // 品牌id
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