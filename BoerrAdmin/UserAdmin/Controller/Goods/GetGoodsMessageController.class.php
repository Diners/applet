<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 9:39
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsCategoryModel;
use UserAdmin\Model\GoodsImageModel;
use UserAdmin\Model\GoodsModel;
use UserAdmin\Model\GoodsStandardModel;

class GetGoodsMessageController extends BaseController
{
    public function index()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $goodsId = I('get.goods_id', 0, 'intval');

        if (!$goodsId) {
            $this->ajaxReturn('商品id不能为空');
        }

        // 获得商品信息
        $goodsModel = new GoodsModel();
        $goodsStandardModel = new GoodsStandardModel();
        $goodsImagesModel = new GoodsImageModel();
        $goodsCatModel = new GoodsCategoryModel();
        $goodsInfo = $goodsModel->getGood($goodsId);
        if (!$goodsInfo) {
            $this->ajaxReturn('商品不存在！');
        }

        // 获得商品图片
        $goodsImages = $goodsImagesModel->getGoodsImages($goodsId);

        // 获得规格信息
        $standardInfo = $goodsStandardModel->getStandards($goodsId);
        if (!$standardInfo) {
            $this->ajaxReturn('商品规格不存在！');
        }
        $catName = $goodsCatModel->getCategory($goodsInfo['cat_id']);
        // 格式返回数据
        $return = [];
        $return['goods_id'] = $goodsInfo['goods_id'];
        $return['goods_name'] = $goodsInfo['goods_name'];
        $return['cat_id'] = $goodsInfo['cat_id'];
        $return['cat_name'] = $catName['cat_name'];
        $return['goods_brief'] = $goodsInfo['goods_brief'];
        foreach ($standardInfo as $key => $val) {
            $return['standard_list'][$key] = [
                'color' => $val['color'],
                'size' => $val['size'],
                'price' => $val['price'],
            ];
        }
        $return['goods_image'] = $goodsImages['thumb_url'];
        $this->ajaxReturn($return);
        return true;
    }
}