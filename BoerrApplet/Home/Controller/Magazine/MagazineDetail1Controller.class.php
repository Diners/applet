<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:14
 */

namespace Home\Controller\Magazine;


use Common\Controller\BaseController;

class MagazineDetail1Controller extends BaseController
{
        public function index ()
        {
        	$userId = I('post.user_id');
            $page=$_POST['page'];
            $magazine_id=$_POST['magazine_id'];
        $find=M('Magazine_detail')->where("magazine_id='{$magazine_id}' && page={$page}")->select();
        foreach ($find as $k=>$v){
            if($find[$k]['mokuai']==1){
                $find11['mokuailist'][1]=$find[$k];
            }elseif($find[$k]['mokuai']==2){
                $find11['mokuailist'][2]=$find[$k];
            }elseif($find[$k]['mokuai']==3){
                $find11['mokuailist'][3]=$find[$k];
            }
        }
        if(empty($find)){
            $arr=[
                    'code' => 0,
                    'message' =>'已经是最后一页了'
            ];
             $this->ajaxReturn($arr);
                return false;
        }
        if($find[0]['moban']==2){
            //进行代理操作
            $result['user_id']=$find[0]['user_id'];
            $result['moban']=2;
            $result['page']=$page;
            $this->ajaxReturn($result);
        }else{
            $find1['mokuailist'][0]= $find11['mokuailist'][1]? $find11['mokuailist'][1]:null;
            $find1['mokuailist'][1]= $find11['mokuailist'][2]? $find11['mokuailist'][2]:null;
            $find1['mokuailist'][2]= $find11['mokuailist'][3]? $find11['mokuailist'][3]:null;
            $find1['moban']=1;
            $find1['page']=$page;
            $this->ajaxReturn($find1);
        }

    }
}