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

class GeneralLstController extends BaseController
{
    //用户的所有订单的列表
    public function index ()
    {
        $type=I('post.order_type');//1未付款，2.未发货 3已发货，4确认收货
        $user_id = I('post.user_id');
        $model1=M('order');
        $model2=M('order_goods');
        $model3=M('goods');
        $model4=M('goods_standard');
        $model5=M('goods_image');
        $order1=$model1->where("buy_user_id='{$user_id}' && order_type='{$type}'  && status<3")->select();
        if(empty($order1)){
            $result['code']=0;
            $result['message']='没有数据';
            return $this->ajaxReturn($result);
        }
        foreach ($order1 as $k=>$v){
            $brand[]=M('goods_brand')->where("brand_id='{$v['brand_id']}'")->field('brand_id,brand_name,brand_logo')->find();
            $order[$k]=$model2->where("order_id='{$v['order_id']}'")->select();
             foreach ($order[$k] as $key=>$value){
                 $goods[$k][]=$model3->where("goods_id='{$value['goods_id']}'")->find();
                 $standard[$k][]=$model4->where("standard_id='{$value['standard_id']}'")->find();
                 $tupian[$k][]=$model5->where("goods_id='{$value['goods_id']}' && img_type=1")->field("thumb_url")->find()['thumb_url'];
                 $goods_message[$k]['goods'][$key]['title']=$goods[$k][$key]['goods_name'];
                 $goods_message[$k]['goods'][$key]['goods_img']=$tupian[$k][$key];
                 $goods_message[$k]['goods'][$key]['colour']=$standard[$k][$key]['color'];
                 $goods_message[$k]['goods'][$key]['size']=$standard[$k][$key]['size'];
                 $goods_message[$k]['goods'][$key]['price']=$standard[$k][$key]['price'];
                 $goods_message[$k]['goods'][$key]['num']=$order[$k][$key]['goods_number'];
             }
            $goods_message[$k]['brand_name']=$brand[$k]['brand_name'];
            $goods_message[$k]['brand_logo']=$brand[$k]['brand_logo'];
            $goods_message[$k]['total_price']=$v['order_price'];
            $goods_message[$k]['coupon_type']=$v['coupon_type'];
            $goods_message[$k]['order_type']=$v['order_type'];
            $goods_message[$k]['order_id']=$v['order_id'];
        }
        $result['goods_message']=$goods_message;
        $result['code']=1;
        return $this->ajaxReturn($result);
    }
}