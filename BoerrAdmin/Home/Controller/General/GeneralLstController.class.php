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
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $brand_id = I('post.brand_id');
        $type=$_POST['type'];
        $model1=M('order');
        $model2=M('order_goods');
        $model3=M('goods');
        $model4=M('goods_standard');
        if(!empty($type)){
            $where=[
                'brand_id'=> $brand_id,
                'order_type'=> $type,
            ];
            $order1=$model1->where($where)->select();
        }else{
            $order1=$model1->where("brand_id='{$brand_id}' && order_type >1")->select();
        }
        if(empty($order1)){
            $result['code']=0;
            $result['message']='暂无数据';
            return $this->ajaxReturn($result);
        }
        foreach ($order1 as $k=>$v){
            $order[$k]=$model2->where("order_id='{$v['order_id']}'")->select();
            $address=M('address')->where("address_id='{$v['address_id']}'")->find();
             foreach ($order[$k] as $key=>$value){
                 $goods[$k][]=$model3->where("goods_id='{$value['goods_id']}'")->find();
                 $standard[$k][]=$model4->where("standard_id='{$value['standard_id']}'")->find();
                 $goods_message[$k]['order']['goods'][$key]['title']=$goods[$k][$key]['goods_name'];
                 $goods_message[$k]['order']['goods'][$key]['colour']=$standard[$k][$key]['color'];
                 $goods_message[$k]['order']['goods'][$key]['size']=$standard[$k][$key]['size'];
                 $goods_message[$k]['order']['goods'][$key]['price']=$standard[$k][$key]['price'];
                     $goods_message[$k]['order']['goods'][$key]['num']=$order[$k][$key]['goods_number'];
             }
            //            1,未付款;2,未发货;3,已发货;4,已收货;
            if($v['order_type']==2){
                $zhuangtai[$k]='未发货';
            }elseif($v['order_type']==3){
                $zhuangtai[$k]='已发货';
            }elseif($v['order_type']==4){
                $zhuangtai[$k]='已收货';
            }
            $goods_message[$k]['order']['order_id']=$v['order_id'];//订单号
            $goods_message[$k]['order']['buy_time']=date("Y-m-d H:i:s",$v['buy_time']);//购买日期
            $goods_message[$k]['order']['user_rec_name']=$address[$k]['user_rec_name'];//购买用户
            $goods_message[$k]['order']['buy_user_phone']=$address[$k]['user_rec_mobile'];//购买手机号
            $goods_message[$k]['order']['remark']=$v['remark'];//备注
            $goods_message[$k]['order']['order_price']=$v['order_price'];//总价
            $goods_message[$k]['order']['order_type']=$zhuangtai[$k];//订单状态
        }
        $result['goods_message']=$goods_message;
        $result['code']=1;
        return $this->ajaxReturn($result);
    }
}