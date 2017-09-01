<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/28 0028
 * Time: 15:54
 */

namespace Home\Controller\Cart;

use Common\Controller\BaseController;
use Home\Model\GoodsCategoryModel;
use Home\Model\GoodsModel;

class ShowCartController extends BaseController
{
    //查看购物车
    public function index(){
      $model=M('cart');
      $model1=M('goods');
      $model2=M('goods_standard');
      $user_id=$_POST['user_id'];
      $data=$model->where("user_id='{$user_id}'")->order('cart_id desc')->select();
      //购物车总值
      foreach ($data as $k => $v) {
        $goods[]=$model1->where("goods_id='{$v['goods_id']}'")->find();
        $standard[]=$model2->where("standard_id='{$v['standard_id']}'")->find();
        $tupian[]=M("goods_image")->where("goods_id={$v['goods_id']} && img_type=1")->field("thumb_url")->find()['thumb_url'];
        $cart[$k]['title']=$goods[$k]['goods_name'];
        $cart[$k]['brand_id']=$v['brand_id'];
        $cart[$k]['num']=$v['num'];
        $cart[$k]['colour']=$standard[$k]['color'];
        $cart[$k]['size']=$standard[$k]['size'];
        $cart[$k]['price']=$standard[$k]['price'] ;
        $cart[$k]['img']= $tupian[$k];
        $cart[$k]['standard_id']=$standard[$k]['standard_id'];
        $cart[$k]['goods_id']=$v['goods_id'];
        $cart[$k]['cart_id']=$v['cart_id'];
      }
        $goodsSort = [];
      foreach ($cart as $k1 => $v1) {
          $ever[]=$v1['money']*$v1['num'];
          $v11=$v1['brand_id'];
          $goodsSort[$v11]['goods'][]=$v1;
          $brand[]=M('goods_brand')->where("brand_id='{$v1['brand_id']}'")->find();
          $goodsSort[$v11]['brand']['brand_name']=$brand[$k1]['brand_name'];
          $goodsSort[$v11]['brand']['brand_img']=$brand[$k1]['brand_logo'];
      }
      $result['total']=array_sum($ever);
      $result['cart']=array_values($goodsSort);
     $result['code']=1;
        return $this->ajaxReturn($result);
    }
}