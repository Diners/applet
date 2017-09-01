<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:14
 */

namespace Home\Controller\Magazine;


use Common\Controller\BaseController;

class MagazineDetailController extends BaseController
{
        public function index ()
        {
//            $magazine_id=$_POST['magazine_id'];
        	$userId = I('post.user_id');
          // user_id 不能为空
            if (!$userId) {
                $errMessage = [
                    'code' => 1,
                    'message' => 'user_id不能为空！'
                ];
                $this->ajaxReturn($errMessage);
                return false;
        }

        $find=M('Magazine')->where("user_id='{$userId}'")->find();
        if(empty($find)){
            $arr=[
                    'user_id' => $userId,
                    'update' => time()
            ];
            $addmagazine=M('Magazine')->add($arr);
        }

        $user=M('user')->where("user_id='{$userId}'")->find();
        $data=M('Magazine')->where("user_id='{$userId}'")->field("magazine_title,magazine_id,title,magazine_cover,description")->find();
        $shoucang=M('magazine_like')->where("magazine_id='{$data['magazine_id']}'")->count();
        $dingyue=M('magazine_like')->where("user_id='{$userId}'")->count();
            $shoucang1=M('magazine_like')->where("magazine_id='{$data['magazine_id']}' && user_id='{$userId}'")->find();
            if(!empty($shoucang1)){
                $result['shoucang1']=1;
            }else{
                $result['shoucang1']=0;
            }
		$result['fans']=$shoucang;
		$result['dingyue']=$dingyue;
        $result['title']=$data['magazine_title'];
        $result['magazine_id']=$data['magazine_id'];
        $result['small_title']=$data['title'];
        $result['desc']=$data['description'];
        $result['cover']=$data['magazine_cover'];
        $result['time']=date("Y/m/d");
        $result['user_name']=$user['user_name'];
        $result['user_head']=$user['user_head'];
        $result['user_diy']=$user['user_diy'];
        $this->ajaxReturn($result);
    }
}