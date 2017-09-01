<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/28 0028
 * Time: 15:54
 */

namespace Home\Controller\Cart;

use Common\Controller\BaseController;

class AddCartController extends BaseController
{
    //加入购物车
    public function index(){
      $model=M('cart');
      $user_id=$_POST['user_id'];
      $goods_id=$_POST['goods_id'];
      $num=$_POST['num'];
      $brand_id=$_POST['brand_id'];
      $standard_id=$_POST['standard_id'];
      $arr['goods_id']= $goods_id;
      $arr['standard_id']= $standard_id;
      $arr['user_id']= $user_id;
      $arr['brand_id']= $brand_id;
      //加入购物车
      //先判断时是否存在当前拥有的购物车数量
      $check=$model->where("user_id='{$user_id}' && goods_id='{$goods_id}' && standard_id='{$standard_id}'")->find();
      if(!empty($check)){
        $arr['num']=$num+$check['num'];
        $shipping=$model->where("cart_id='{$check['cart_id']}'")->save($arr);
      }else{
        $arr['num']= $num;
        $shipping=$model->add($arr);
      }
      if(!empty($shipping)){
          $result['code']=1;
      }else{
          $result['code']=0;
      }
      echo json_encode($result);
    }
}