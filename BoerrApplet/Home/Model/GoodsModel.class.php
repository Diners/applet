<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:01
 */

namespace Home\Model;

use Common\Model\BaseModel;

class GoodsModel extends BaseModel
{
    /**
     * 根据商品id获得商品信息
     * @param $goodsIds array 商品id
     * @return array 商品信息
     */
    public function getGoodsList ($goodsIds)
    {
        if (!is_array($goodsIds)) {
            \Think\Log::write('商品id必须为数组格式！');
            return flase;
        }
        $idStr = implode(',',$goodsIds);

        // 获得文章列表
        $goodsList = $this->where("goods_id IN ({$idStr}) AND is_on_sale = 0 AND".STATUS)->select();
        if (!$goodsList) {
            \Think\Log::write('文章不存在！');
            return flase;
        }
        return $goodsList;
    }

    /**
     * 根据商品id获得总数
     * @param $goodsIds array 商品id
     * @return int 商品总数
     */
    public function getGoodsCount ($goodsIds)
    {
        if (!is_array($goodsIds)) {
            \Think\Log::write('商品id必须为数组格式！');
            return flase;
        }
        $ids = array_column($goodsIds, 'goods_id');
        $idStr = implode(',',$ids);
        $count = $this->where("goods_id IN ({$idStr}) AND",STATUS)->count();

        return $count;
    }

    /**
     * 根据id获得一个商品信息
     * @param $goodsId int 商品i
     * @return array 商品信息d
     */
    public function getGoodsOne ($goodsId)
    {
        if (!$goodsId) {
            \Think\Log::write('商品id不能为空！');
            return flase;
        }
        $goods = $this->where("goods_id = {$goodsId} AND".STATUS." AND".IS_ON_SALE)->find();
        if (!$goods) {
            \Think\Log::write('商品不存在！');
            return flase;
        }
        return $goods;
    }

    /**
     * 根据goods_id获取品牌列表
     * @param $goodsIds
     * @return mixed
     */
    public function getBrandByGoodsId ($goodsIds, $page, $pageSize)
    {
        $idStr = implode(',',$goodsIds);
        $list = $this->where("goods_id IN ({$idStr}) AND".STATUS)->group('brand_id')->page($page, $pageSize)->select();
        return $list;
    }

    /**
     * 根据品牌id获得商品列表
     * @param $brandId
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function getGoodsByBrandId ($brandId, $categoryId, $page, $pageSize)
    {
        // 如果品牌id为空，查全部商品
        $categoryStr = '';

        if ($categoryId != 1) {
            $categoryStr = 'cat_id = '.$categoryId.' AND';
        }
        $list = $this->where($categoryStr." brand_id = {$brandId} AND is_on_sale = 0 AND".STATUS)->page($page, $pageSize)->select();
        return $list;
    }

    /**
     * 获取该分类下的商品总数
     * @param $brandId
     * @param $categoryId
     * @return mixed
     */
    public function getGoodsByBrandIdCount ($brandId, $categoryId)
    {
        // 如果品牌id为空，查全部商品
        $categoryStr = '';
        if ($categoryId !== 0) {
            $categoryStr = 'cat_id = '.$categoryId.' AND';
        }
        $count = $this->where($categoryStr." brand_id = {$brandId} AND".STATUS)->count();
        return $count;
    }

    public function getGoodsByGoodsStandard ($goodsIds, $standardId)
    {
        if (!is_array($goodsIds) && !is_array($standardId)) {
            \Think\Log::write('商品id和规格id必须为数组格式！');
            return flase;
        }
        $goodsIdStr = implode(',',$goodsIds);
        $standardIdStr = implode(',',$standardId);

        // 获得文章列表
        $goodsList = $this->join('boerr_goods_standard ON boerr_goods.goods_id = boerr_goods_standard.goods_id')->where("boerr_goods.goods_id IN ({$goodsIdStr}) AND boerr_goods_standard.standard_id IN ({$standardIdStr})")->select();
        if (!$goodsList) {
            \Think\Log::write('文章不存在！');
            return flase;
        }
        return $goodsList;
    }
}