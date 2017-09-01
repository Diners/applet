<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/27 0027
 * Time: 11:33
 */

namespace Home\Controller\Goods;

use Common\Controller\BaseController;
use Home\Model\GoodsBrandModel;
use Home\Model\GoodsCollectModel;
use Home\Model\GoodsImageModel;
use Home\Model\GoodsModel;
use Home\Model\GoodsStandardModel;

class GoodsDetailController extends BaseController
{
    // 商品详情接口
    public function index()
    {
        $goodsId = I('get.goods_id', 0, 'intval');
        $userId = I('get.user_id', 0, 'intval');

        if (!$goodsId) {
            $errMessage = [
                'code' => 1,
                'message' => '商品详情提交为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $goodsModel = new GoodsModel();
        $goodsImageModel = new GoodsImageModel();
        $goodsStandardModel = new GoodsStandardModel();
        $goodsBrandModel = new GoodsBrandModel();
//        $goodsCollectModel = new GoodsCollectModel();
        $result = [];
        // 获得商品信息
        $goodsInfo = $goodsModel->getGoodsOne($goodsId);
        if (!$goodsInfo) {
            $errMessage = [
                'code' => 1,
                'message' => '商品不存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 获得商品图片
        $lunboImageType = GOODS_IMAGE_TYPE3;
        $detailImageType = GOODS_IMAGE_TYPE2;
        $goodsImages = $goodsImageModel->getGoodsImages($goodsId, $lunboImageType);
        $detailmagesList = $goodsImageModel->getGoodsImages($goodsId, $detailImageType);

        // 格式列表，获得图片url
        $images = array_column($goodsImages, 'thumb_url');
        $detailmages = array_column($detailmagesList, 'thumb_url');

        // 获得商品规格
        $goodsStandard = $goodsStandardModel->getStandardByGoodsId($goodsId);
        if (!$goodsStandard) {
            $errMessage = [
                'code' => 1,
                'message' => '商品规格不存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 格式规格数组
        foreach ($goodsStandard as $key => $val) {
            $result['goods_standard'][$key]['standard_id'] = $val['standard_id'];
            $result['goods_standard'][$key]['color'] = $val['color'];
            $result['goods_standard'][$key]['size'] = $val['size'];
            $result['goods_standard'][$key]['standard_image'] = $val['standard_image'];
            $result['goods_standard'][$key]['price'] = $val['price'];
        }

        // 获得平台信息
        $goodsBrand = $goodsBrandModel->getBrandOne($goodsInfo['brand_id']);

        if (!$goodsBrand) {
            $errMessage = [
                'code' => 1,
                'message' => '该商品不属于任何平台！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 获得收藏信息
//        $collectType = $goodsCollectModel->getCollectType($userId, $goodsId);

        // 商品信息
        $result['goods_info'] = [
            'goods_id' => $goodsInfo['goods_id'],
            'goods_name' => $goodsInfo['goods_name'],
            'goods_price' => $goodsInfo['goods_price'],
            'goods_desc' => $goodsInfo['goods_desc'],
            'goods_brief' => $goodsInfo['goods_brief'],
            'goods_thumb' => $goodsInfo['goods_thumb'],
            'goods_sell_number' => $goodsInfo['goods_sell_number'],
            'save_count' => $goodsInfo['save_count'],
        ];
        // 商品图片
        $result['goods_images'] = $images;
        $result['goods_detail_images'] = $detailmages;
        $result['brand'] = [
            'brand_id' => $goodsBrand['brand_id'],
            'brand_name' => $goodsBrand['brand_name'],
            'brand_img' => $goodsBrand['brand_logo'],
            'brand_label' => $goodsBrand['brand_introd'],
            'brand_desc' => $goodsBrand['brand_desc'],
        ];
//        $result['collect_type'] = $collectType['collect_type'];
        $this->ajaxReturn($result);
        return true;

    }
}