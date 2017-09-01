<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/28 0028
 * Time: 15:54
 */

namespace Home\Controller\Cart;

use Common\Controller\BaseController;

class DelCartController extends BaseController
{

   //删除购物车
    public function index(){
      $model=M('cart');
      $cart_id=I('post.cart_id');
      $data=$model->where("cart_id='{$cart_id}'")->delete();
      if(!empty($data)){
                $result['code']=1;
                $result['message']='删除成功';
              }else{
                 $result['code']=0;
          $result['message']='删除失败';
              }
        $this->ajaxReturn($result);
    }

}