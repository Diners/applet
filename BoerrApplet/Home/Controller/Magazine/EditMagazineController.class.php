<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:16
 */

namespace Home\Controller\Magazine;


use Common\Controller\BaseController;

class EditMagazineController extends BaseController
{
    public function index ()
    {
		$userId = I('post.user_id');
		$magazine_id=$_POST['magazine_id'];
		$desc=$_POST['desc'];
		$magazine_title=$_POST['magazine_title'];
		$title=$_POST['title'];
//		$magazine_cover=$_POST['magazine_cover'];
//        $imageConf = C('FENGMIAN_IMAGE_CONF');
//        $info = $this->uploadImages($imageConf);
				$data=array();
				$data['description']=$desc;
				 $data['magazine_title']=$magazine_title;
				 $data['title']=$title;
//				 $data['magazine_cover']=$info;
				 $data['update']=time();
        $edit=M('Magazine')->where("user_id={$userId}")->save($data);
        if (empty($edit)) {
	                $errMessage = [
	                    'code' => 1,
	                    'message' => '修改失败'
	                ];
	                $this->ajaxReturn($errMessage);
	                return false;
	        }
	        $result = [
	                    'code' => 1,
	                    'message' => '修改成功'
	                ];
	       $this->ajaxReturn($result); 
	    
    }
}