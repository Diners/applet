<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/10 0010
 * Time: 17:07
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsImageModel;
use UserAdmin\Model\GoodsModel;
use UserAdmin\Model\GoodsStandardModel;
use Common\Model\BaseModel;
class AddGoodsController extends BaseController
{
    // 添加商品
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $goodsName = I('post.goods_name', '', 'trim');
        $catId = I('post.cat_id', 0, 'intval');
        $brandId = I('post.brand_id', 0, 'intval');
//        $goodsPrice = I('post.goods_price', 0, 'intval');
//        $goodsDesc = I('post.goods_desc', '', 'trim');
        $goodsBrief = I('post.goods_brief', '', 'trim');
//        $saleStatus = I('post.is_on_sale', 0, 'intval');
//        $goodsNote = I('post.goods_note', '', 'trim');

        $goodsImageKey = 'goods_image';
//        $standardImageKey = 'standard_image';
        $standardColor = I('post.color');
        $standardSize = I('post.size');
        $standardPrice = I('post.price');
        // 参数不能为空
        if (!$goodsName || !$catId || !$brandId || !$goodsBrief) {
            $this->ajaxReturn('商品参数不能为空！');
        }

        if (!$standardColor || !$standardSize || !$standardPrice) {
            $this->ajaxReturn('规格参数不能为空！');
        }
        if (count($standardColor) != count($standardColor) || count($standardColor) != count($standardPrice)) {
            $this->ajaxReturn('规格参数数组长度必须相同！');
        }
        $goodsModel = new GoodsModel();
        $goodsImagesModel = new GoodsImageModel();
        $goodStandardModel = new GoodsStandardModel();
        $goodsAddData = [
            'goods_name' => $goodsName,
            'cat_id' => $catId,
            'brand_id' => $brandId,
            'goods_brief' => $goodsBrief,
            'status' => 1,
            'created' => time()
        ];
        // 商品信息入库
        $goodId = $goodsModel->addGoods($goodsAddData);
        if (!$goodId) {
            $this->ajaxReturn('商品上传失败！');
        }
        // 获得上传图片
        $goodImageConf = C('GOODS_IMAGE_CONF');
        $goodsImages = $this->uploadImages($goodImageConf , $goodsImageKey);
        $imageUrls = [];
        foreach ($goodsImages as $key => $val) {
            $imageUrls[$key]['thumb_url'] = $val;
            $imageUrls[$key]['goods_id'] = $goodId;
            $imageUrls[$key]['image_type'] = GOODS_IMAGE_TYPE2;
        }
        $goodsResult = $goodsImagesModel->addGoodsImages($imageUrls);
        if (!$goodsResult) {
            $this->ajaxReturn('商品图片上传失败！');
        }

        // 规格数据入库
        foreach ($standardColor as $key => $val) {
            $standardAddData = [
                'goods_id' => $goodId,
                'color' => $val,
                'size' => $standardSize[$key],
                'price' => $standardPrice[$key],
                'status' => 1,
                'created' => time(),
            ];
            $standardId = $goodStandardModel->addStandard($standardAddData);
            if (!$standardId) {
                $this->ajaxReturn('规格信息上传失败！');
            }
//            $standardImages = $this->uploadImage($goodImageConf, $standardImageKey, $key);
//            $updateStandard = [
//                'thumb_url' => $standardImages,
//            ];
//            $standardResult = $goodStandardModel->updateStandardImage($standardId, $updateStandard);
//            if (!$standardResult) {
//                $this->error('规格图片上传失败');
//            }
        }
        $this->ajaxReturn(true);
    }
}