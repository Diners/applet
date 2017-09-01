<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:18
 */

namespace Home\Controller\Magazine;


use Common\Controller\BaseController;

class LikeMagazineController extends BaseController
{
    public function index ()
    {
        $user_id=I('post.user_id');
        $magazine_id=I('post.magazine_id');
        $model=M('magazine_like');
        $arr=[
	        'magazine_id'=> $magazine_id,
	        'user_id' => $user_id,
	        'created_time' =>date("Y-m-d H:i:s", time()) 
        ];
    $data=$model->where("magazine_id='{$magazine_id}' && user_id='{$user_id}'")->find();
        if(empty($data)){
            $data1=$model->add($arr);
              if(!empty($data1)){
                $result=[
	                'code'=>1,
	                'message'=>'添加收藏成功'
	             ];
              }else{
                 $result=[
	                'code'=>0,
	                'message'=>'添加收藏失败'
	             ];
              }
        }else{
            $data2=$model->where("magazine_id='{$magazine_id}' && user_id='{$user_id}'")->delete();
              if(!empty($data2)){
                $result=[
	                'code'=>1,
	                'message'=>'取消收藏成功'
	             ];
              }else{
                 $result=[
	                'code'=>0,
	                'message'=>'取消收藏失败'
	             ];
              }
        }
         $this->ajaxReturn($result);
    }
}
