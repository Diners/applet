<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 15:52
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsImageModel;
use UserAdmin\Model\GoodsModel;
use UserAdmin\Model\GoodsStandardModel;

class EditGoodsController extends BaseController
{
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $goodsId = I('post.goods_id', 0, 'intval');
        $goodsName = I('post.goods_name', '', 'trim');
        $catId = I('post.cat_id', 0, 'intval');
        $brandId = I('post.brand_id', 0, 'intval');
        $goodsBrief = I('post.goods_brief', '', 'trim');
        if (!$goodsId) {
            $this->ajaxReturn('商品id不能为空！');
        }

        $goodsImageKey = 'goods_image';
        $standardColor = I('post.color');
        $standardSize = I('post.size');
        $standardPrice = I('post.price');

        $goodsModel = new GoodsModel();
        $goodsImagesModel = new GoodsImageModel();
        $goodsStandardModel = new GoodsStandardModel();
        $saveData = [];
        if ($goodsName) {
            $saveData['goods_name'] = $goodsName;
        }
        if ($catId) {
            $saveData['cat_id'] = $catId;
        }
        if ($catId) {
            $saveData['brand_id'] = $brandId;
        }
        if ($catId) {
            $saveData['goods_brief'] = $goodsBrief;
        }
        // 如果商品信息有修改
        if ($saveData) {
            $goodsModel->saveGoods($goodsId, $saveData);
        }

        // 替换图片
        $goodImageConf = C('GOODS_IMAGE_CONF');
        $goodsImages = $this->uploadImages($goodImageConf , $goodsImageKey);
        $imageUrls = [];

        if ($goodsImages) {
            // 删除图片
            $goodsImagesModel->deleteImages($goodsId);
            foreach ($goodsImages as $key => $val) {
                $imageUrls[$key]['thumb_url'] = $val;
                $imageUrls[$key]['goods_id'] = $goodsId;
            }
            $addImageResult = $goodsImagesModel->addGoodsImages($goodsImages);
            if (!$addImageResult) {
                $this->ajaxReturn('商品图片上传失败！');
            }
        }

        // 替换规格
        if ($standardColor) {
            // 删除规格
            $goodsStandardModel->deleteStandard($goodsId);
            foreach ($standardColor as $key => $val) {
                $standardAddData = [
                    'goods_id' => $goodsId,
                    'color' => $val,
                    'size' => $standardSize[$key],
                    'price' => $standardPrice[$key],
                    'status' => 1,
                    'created' => time(),
                ];
                $standardId = $goodsStandardModel->addStandard($standardAddData);
                if (!$standardId) {
                    $this->ajaxReturn('规格信息上传失败！');
                }
            }
        }
        $this->ajaxReturn(true);
    }
}