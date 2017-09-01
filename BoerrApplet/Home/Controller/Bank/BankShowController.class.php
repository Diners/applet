<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/29 0029
 * Time: 15:19
 */

namespace Home\Controller\Bank;

use Common\Controller\BaseController;
use Home\Model\GoodsModel;
use Home\Model\OrderGoodsModel;
use Home\Model\OrderModel;

class BankShowController extends BaseController
{
    //用户的所有订单的列表
    public function index ()
    {
        $user_id = I('post.user_id');
        $model1=M('bank');
        $order1=$model1->where("user_id='{$user_id}'")->find();
        $result['total_money']=$order1['money']?$order1['money']:0.00;
        $result['code']=1;
        return $this->ajaxReturn($result);
    }
}