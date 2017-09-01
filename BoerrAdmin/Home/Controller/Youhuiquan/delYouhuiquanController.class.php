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

class DelYouhuiquanController extends BaseController
{
    // 删除促销
    public function del_cuxiao()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $activitylist=M("Activitylist");
        $id=$_POST['id'];
        $type=$_POST['type'];

        if($type==1){
            $arr=array();
            $arr['state']=2;
            foreach ($id as $k=>$v){
                $update=$activitylist->where("id='{$v['id']}'")->save($arr);
            }
            if($update){
                $this->redirect("marketing/cuxiao_list");
            }
        }else{
            $arr['state']=3;
            foreach ($id as $k=>$v){
                $update=$activitylist->where("id='{$v['id']}'")->save($arr);
            }
            if($update){
                $this->redirect("marketing/cuxiao_list");
            }
        }
    }

    public function del_cuxiao1()
    {
        $cuxiao=M("Cuxiao");
        $id=$_POST['id'];
        $type=$_POST['type'];

        // 查询对应批次号
        $find_pici=$cuxiao->where("id='{$id[0]['id']}'")->find();
        if($type==1){

            $arr=array();
            $arr['state']=2;
            foreach ($id as $k=>$v){
                $update=$cuxiao->where("id='{$v}'")->save($arr);
            }
            if($update){
                $this->redirect("marketing/cuxiao_bianji",array("id"=>$find_pici['code']));
            }

        }else{
            $arr['state']=3;
            foreach ($id as $k=>$v){
                $update=$cuxiao->where("id='{$v}'")->save($arr);
            }
            if($update){
                $this->redirect("marketing/cuxiao_bianji",array("id"=>$find_pici['code']));
            }
        }

    }
}