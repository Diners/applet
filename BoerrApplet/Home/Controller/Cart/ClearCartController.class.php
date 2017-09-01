<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/28 0028
 * Time: 15:54
 */

namespace Home\Controller\Cart;

use Common\Controller\BaseController;


class ClearCartController extends BaseController
{
    //清空购物车
    public function index(){
        $model=M('cart');
        $user_id=$_POST['user_id'];
        $data=$model->where("user_id='{$user_id}'")->delete();
        if(!empty($data)){
            $result['code']=1;
        }else{
            $result['code']=0;
        }
        echo json_encode($result);
    }

}