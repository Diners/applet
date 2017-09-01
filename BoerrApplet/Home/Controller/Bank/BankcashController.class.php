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

class BankcashController extends BaseController
{
    //用户的所有订单的列表
    public function index ()
    {
        $user_id = I('post.user_id');
        $money = I('post.money');
        $model1=M('bank');
        $model2=M('cash_record');
        $order1=$model1->where("user_id='{$user_id}'")->find();
        if($order1['money']<$money){
            $result['code']=0;
            $result['message']='提现异常，请联系客服';
            return $this->ajaxReturn($result);
        }
        $arr=[
            'user_id'=>$user_id,
            'type'=>2,
            'money'=>$money,
            'status'=>0,
            'time'=>time()
        ];
        $add_record=$model2->add($arr);
        if(!empty($add_record)){
           $upmoney= $order1['money']-$money;
           $arr1['money']=$upmoney;
           $arr1['update']=time();
            $up_bank=$model1->where("user_id='{$user_id}'")->save($arr1);
        }else{
            $result['code']=0;
            $result['message']='提现申请失败，请联系客服';
        }

        if(!empty($up_bank)){
            $result['code']=1;
            $result['message']='提现成功，正在审核';
        }else{
            $result['code']=0;
            $result['message']='扣款失败，请联系客服';
        }
        return $this->ajaxReturn($result);
    }
}