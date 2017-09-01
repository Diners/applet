<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/2 0002
 * Time: 10:56
 */

namespace Home\Controller\Youhuiquan;

use Common\Controller\BaseController;
use Home\Model\AddressModel;
use Home\Model\GoodsBrandModel;
use Home\Model\GoodsImageModel;
use Home\Model\GoodsModel;
use Home\Model\GoodsStandardModel;
use Home\Model\OrderGoodsModel;
use Home\Model\OrderModel;
use Home\Model\OrderPayModel;

class AddYouhuiquanController extends BaseController
{
    // 添加优惠券
    public function index()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $activitylist=M("Activitylist");
        $type=$_POST["type"]?$_POST["type"]:1;
        $brand=I('post.brand_id');
        $name=I('post.name');
        $man=I('post.man');
        $jian=I('post.jian');
        $start_time=I('post.start_time');
        $end_time=I('post.end_time');
        $count=I('post.count');
        $beizhu=I('post.beizhu');
        $arr=array();
        // 判断开始时间不能大于结束时间
        if (strtotime($start_time) > strtotime($end_time)) {
            $this->error('开始时间不能大于结束时间！');
        }
        $arr['activity_label']=$name;
        $arr['activity_son_type']=$type;
        $arr['money']=$man;
        $arr['discount']=$jian;
        $arr['created_time']=$start_time;
        $arr['end_time']=$end_time;
        $arr['count']=$count;
        $arr['beizhu']=$beizhu;
        $arr['brand']=$brand;
        $code=rand(100000,999999);
        $arr['code']= $code;
        $save_cuxiao=$activitylist->add($arr);
        for ($i=1;$i<=$count;$i++){
            $a[$i]=rand(1000,9999).time().rand(100,999);
            $b[$i]=rand(100,999).time().rand(1000,9999);
        }
        foreach($a as $k=>$v){
            $arr1=array();
            $arr1['code']=$code;
            $arr1['zhanghao']=$v;
            $arr1['mima']=$b[$k];
            $arr1['created_time']=time();
            $cuxiao1=M('cuxiao')->add($arr1);
        }
        if(!empty($cuxiao1)){
            $result['code']=1;
            $result['message']='优惠券添加成功';
        }else{
            $result['code']=1;
            $result['message']='优惠券添加失败';
        }
        $this->ajaxReturn($result);
    }

}