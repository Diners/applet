<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/29 0029
 * Time: 15:19
 */

namespace Home\Controller\General;

use Common\Controller\BaseController;
use Home\Model\GoodsModel;
use Home\Model\OrderGoodsModel;
use Home\Model\OrderModel;

class GeneralSureController extends BaseController
{
    //用户确认收货
    public function index ()
    {
        $order_id=I('post.order_id');
        $model1=M('order');
        $order1=$model1->where("order_id='{$order_id}'")->find();
        if(empty($order1)){
            $result['code']=0;
            $result['message']='订单不存在';
            return $this->ajaxReturn($result);
        }
        if($order1['order_type']!=3 ){
            $result['code']=0;
            $result['message']='订单状态异常';
            return $this->ajaxReturn($result);
        }
        $buy_bank=M('bank')->where("user_id='{$order1['buy_user_id']}'")->find();
        if(empty($buy_bank)){
            $arr['user_id']=$order1['buy_user_id'];
            $arr['update']=time();
            $add_buy_bank=M('bank')->add($arr);
        }
        $receive_bank=M('bank')->where("user_id='{$order1['receive_user_id']}'")->find();
        if(empty($receive_bank)){
            $arr['user_id']=$order1['receive_user_id'];
            $arr['update']=time();
            $add_receive_bank=M('bank')->add($arr);
        }
        $newmoney=$receive_bank['money']?$receive_bank['money']:0;
        $addmoney=$order1['order_price']*0.95;
        $total_money=$newmoney+$addmoney;
        $arr111['update']=time();
        $arr111['money']=$total_money;
        $save_receive_bank=M('bank')->where("user_id='{$order1['receive_user_id']}'")->save($arr111);
        if(!empty($save_receive_bank)){
            $arr=[
                'user_id'=>$order1['receive_user_id'],
                'type'=>1,
                'money'=>$addmoney,
                'order_id'=>$order1['order_id'],
                'status'=>1,
                'time'=>time()
            ];
            $add_cash_record=M('cash_record')->add($arr);
        }else{
            $result['code']=0;
            $result['message']='订单异常，请联系客服务';
            return $this->ajaxReturn($result);
        }
        if(!empty($add_cash_record)){
            $arr=[
                'order_type'=>4,
                'accept_time'=>time()
            ];
            $add_order=M('order')->where("order_id='{$order1['order_id']}'")->save($arr);
        }else{
            $result['code']=2;
            $result['message']='订单记录保存异常，请联系客服务';
        }
        if(!empty($add_order)){
           $result['code']=1;
            $result['order_type']=4;
            $result['message']='确认收货成功';
        }else{
            $result['code']=3;
            $result['message']='确认收货异常，请联系客服务';
        }
        return $this->ajaxReturn($result);
    }
}