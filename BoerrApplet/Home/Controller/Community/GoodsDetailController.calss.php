<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:06
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;
use Home\Model\GoodsImageModel;
use Home\Model\GoodsModel;

class GoodsDetailController extends BaseController
{
    /**
     * 商品详情
     */
    public function index ()
    {
        $goodsId = I('get.goods_id', 0, 'intval');
        if (!$goodsId) {
            $errMessage = [
                'code' => 1,
                'message' => '商品id为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $goodsModel = new GoodsModel();
        $goodsImageModel = new GoodsImageModel();
        // 获得商品信息
        $goods = $goodsModel->getGoodsOne($goodsId);
        // 图片列表
        $imageList = $goodsImage = $goodsImageModel->getGoodsImages($goodsId);
        $imageList = array_column($imageList, 'thumb_url');
        $result['goods_detail'] = [
            'goods_id' => $goods['goods_id'],
            'goods_name' => $goods['goods_name'],
            'goods_price' => $goods['goods_price'],
            'goods_desc' => $goods['goods_desc'],
            'goods_thumb' => $goods['goods_thumb'],
            'is_on_sale' => $goods['is_on_sale'],
            'like_count' => $goods['like_count'],
            'save_count' => $goods['save_count'],
            'goods_image' => $imageList
        ];
        $this->ajaxReturn($result);
        return true;
    }
}