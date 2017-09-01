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

class BankLstController extends BaseController
{
    //用户的所有订单的列表
    public function index ()
    {
        $user_id = I('post.user_id');
        $model1=M('bank');
        $model2=M('cash_record');
        $model4=M('order_goods');
        $model5=M('goods_image');
        $model6=M('order');
        //显示余额
        $order1=$model1->where("user_id='{$user_id}'")->find();
        $result['top']['total_money']=$order1['money']?$order1['money']:0.00;
        //显示当前所有已确认收货订单的价格之和
        $total_money=$model6->where("receive_user_id='{$user_id}' && order_type=4 ")->sum('order_price');
        $result['top']['add_money']=$total_money*0.95;
        //显示当前所有已付款订单的价格之和
        $total_money1=$model6->where("buy_user_id='{$user_id}' && order_type>1 ")->sum('order_price');
        $result['top']['del_money']=$total_money1?$total_money1:0;
        //交易记录
       //记录包括卖出、买入和提现三种
        $record=$model2->where("user_id='{$user_id}' && status=1")->order("time desc")->select();
        foreach ($record as $k=>$v){
            $type[$k]=$v['type'];    //0是付款，1是收款，2是提现，3是退款
            $message[$k]=$v['order_id']?'订单号:'.$v['order_id']:'微信提现';
            $message1[$k]=$v['order_id']?$v['order_id']:'微信提现';
            $order[$k]=$model4->where("order_id='{$v['order_id']}'")->find();
            $image1[$k]=$model5->where("goods_id='{$order[$k]['goods_id']}' && img_type=1")->field("thumb_url")->find()['thumb_url'];
            $money[$k]=$v['money'];
            $time1[$k]= date('m-d H:i', $v['time']);
            $image[$k]=$image1[$k]?$image1[$k] : 'https://www.boerr.cn/Uploads/Image/fengmian/87915537939035162.png';
            $result['botton'][$k]['type']=$type[$k];
            $result['botton'][$k]['message']=$message[$k];
            $result['botton'][$k]['money']=$money[$k];
            $result['botton'][$k]['time1']=$time1[$k];
            $result['botton'][$k]['image']=$image[$k];

        }
        $result['code']=1;
        return $this->ajaxReturn($result);
    }
}