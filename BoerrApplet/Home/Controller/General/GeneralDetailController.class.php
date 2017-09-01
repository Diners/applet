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
    public function index ()
    {
        $order_id=I('post.order_id');
        $user_id = I('post.user_id');
        $model1=M('order');
        $model2=M('order_goods');
        $model3=M('goods');
        $model4=M('goods_standard');
        $model5=M('goods_image');
        $order1=$model1->where("order_id='{$order_id}'")->find();
        if(empty($order1)){
            $result['code']=0;
            $result['message']='error';
            return $this->ajaxReturn($result);
        }

        $address=M('address')->where("address_id='{$order1['address_id']}'")->find();
        $brand=M('goods_brand')->where("brand_id='{$order1['brand_id']}'")->field('brand_id,brand_name,brand_logo')->find();
            $order123=$model2->where("order_id='{$order_id}'")->select();
             foreach ($order123 as $k=>$v){
                 $goods[]=$model3->where("goods_id='{$v['goods_id']}'")->find();
                 $standard[]=$model4->where("standard_id='{$v['standard_id']}'")->find();
                 $tupian[]=$model5->where("goods_id='{$v['goods_id']}' && img_type=1")->field("thumb_url")->find()['thumb_url'];
                 $goods_message['goods'][$k]['title']=$goods[$k]['goods_name'];
                 $goods_message['goods'][$k]['goods_img']=$tupian[$k];
                 $goods_message['goods'][$k]['colour']=$standard[$k]['color'];
                 $goods_message['goods'][$k]['size']=$standard[$k]['size'];
                 $goods_message['goods'][$k]['price']=$standard[$k]['price'];
                 $goods_message['goods'][$k]['num']=$order123[$k]['goods_number'];
             }
        //1未付款，2.未发货 3已发货，4确认收货
        if($order1['order_type']==3){
            $goods_message['order']['message']='您的订单开始处理';
            $goods_message['order']['message_time']=date("Y-m-d h:i:s", $order1['out_time']);
        }
        if($order1['order_type']==4){
            $goods_message['order']['message']='您的订单已签收';
            $goods_message['order']['message_time']=date("Y-m-d h:i:s", $order1['accept_time']);
        }
        $goods_message['order']['user_rec_name']=$address['user_rec_name'];
        $goods_message['order']['user_rec_mobile']=$address['user_rec_mobile'];
        $goods_message['order']['user_address']=$address['user_address'];
        $goods_message['order']['user_detail_addr']=$address['user_detail_addr'];
        $goods_message['order']['brand_name']=$brand['brand_name'];
        $goods_message['order']['brand_logo']=$brand['brand_logo'];
        $goods_message['order']['total_price']=$order1['order_price'];
        $goods_message['order']['coupon_type']=$order1['coupon_type'];
        $goods_message['order']['order_type']=$order1['order_type'];
        $goods_message['order']['order_id']=$order1['order_id'];
        $goods_message['order']['remark']=$order1['remark'];
        $goods_message['order']['transport_number']=$order1['transport_number'];


        $result['goods_message']=$goods_message;
        $result['code']=1;
        return $this->ajaxReturn($result);
    }
}