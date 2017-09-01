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

class GeneralDetailController extends BaseController
{
    //用户的订单详情的列表
    public function index()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $order_id=I('post.order_id');
        $model1=M('order');
        $order1=$model1->where("order_id='{$order_id}'")->find();
        $address=M('address')->where("address_id='{$order1['address_id']}'")->find();
            $semd_time=$order1['out_time']?date("Y-m-d H:i:s",$order1['out_time']):'尚未发货';
            $wuliu= $order1['transport_number']?$order1['transport_number']:'尚未发货';
        $rec_time=$order1['accept_time']?date("Y-m-d H:i:s",$order1['out_time']):'尚未确认收货';
        if(empty($order1['accept_time'])&& empty($order1['out_time'])){
            $rec_time='尚未发货';
        }
        $goods_message['user_rec_name']=$address['user_rec_name'];//收货人
        $goods_message['user_rec_mobile']=$address['user_rec_mobile'];//收货人手机号码
        $goods_message['user_address']=$address['user_address'].$address['user_detail_addr'];//收货人地址
        $goods_message['sendtime']=$semd_time;
        $goods_message['transport_number']=$wuliu;
        $goods_message['rec_time']=$rec_time;


        $result['order_message']=$goods_message;
        $result['code']=1;
        return $this->ajaxReturn($result);
    }
}