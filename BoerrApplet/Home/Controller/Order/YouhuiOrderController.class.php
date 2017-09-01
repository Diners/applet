<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/29 0029
 * Time: 15:19
 */

namespace Home\Controller\Order;

use Common\Controller\BaseController;

class YouhuiOrderController extends BaseController
{
    // 订单列表生成优惠券
    public function index ()
    {
        $user_id=I('post.user_id');
        $brand_id=I('post.brand_id');
        $code=$_POST['code'];
        $goods_id=$_POST['goods_id'];
        $model=M('cuxiao');
        $model1=M('activitylist');
        //获取用户所有保存的记录
        $data=$model->where(" mima='{$code}'")->find();
        if(empty($data)){
            $result['state']='优惠码不存在，请输入正确的优惠码';
        }elseif($data['state']==1){
            $result['state']='优惠码已使用，请使用新的优惠码';
        }elseif($data['state']==2){
            $result['state']='优惠码已作废，请使用新的优惠码';
        }elseif($data['state']==0){
            $type=$model1->where("code={$data['code']}")->find();
            $aaa=array_search("{$type['goods_id']}",$goods_id);
            $goods1_id1=$goods_id[$aaa];
            if($type['goods_id']==0 || empty($goods1_id1==$type['goods_id'])){
                $result['tyle']=$type['activity_son_type'];
                $result['money']=$type['money'];
                $result['discount']=$type['discount'];
                $result['state']='优惠码兑换成功';
                $arr=[
                    'user_id'=> $user_id,
                    'shiyong_time'=> time(),
                    'goods_id'=> $goods1_id1,
                    'state'=> 1,
                ];
                $data1=$model->where(" mima='{$code}'")->save($arr);
                $data12=$model->where(" code='{$data['code']}'")->find();
                $new_count=$data12['count_shiyong']+1;
                $arr1['count_shiyong']=$new_count;
                if($new_count==$data12['count']){
                    $arr1['state']=1;
                }
                $data12=$model->where(" code='{$data['code']}'")->save($arr1);
            }else{
                $result['state']='该优惠码为指定商品可用，该商品不支持';
            }
        }
        $result['code']=1;
        return $this->ajaxReturn($result);
    }
}