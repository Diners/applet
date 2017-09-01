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
    //用户确认发货
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $order_id=I('post.order_id');
        $num=I('post.num');
        $model1=M('order');
        $order1=$model1->where("order_id='{$order_id}'")->find();
        if(empty($order1)){
            $result['code']=0;
            $result['message']='订单不存在';
            return $this->ajaxReturn($result);
        }
        if($order1['order_type']!=2){
            $result['code']=2;
            $result['message']='订单状态异常';
            return $this->ajaxReturn($result);
        }
        if(empty($num)){
            $result['code']=3;
            $result['message']='快递单号异常';
            return $this->ajaxReturn($result);
        }
    $arr=[
        'order_type'=>3,
        'out_time'=>time(),
        'transport_number'=>$num
    ];
        $order11=$model1->where("order_id='{$order_id}'")->save($arr);


        if(!empty($order11)){
           $result['code']=1;
            $result['order_type']=4;
            $result['message']='发货成功';
        }else{
            $result['code']=3;
            $result['message']='发货异常';
        }
        return $this->ajaxReturn($result);
    }
}