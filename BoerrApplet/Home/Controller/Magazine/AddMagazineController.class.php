<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:13
 */

namespace Home\Controller\Magazine;

use Common\Controller\BaseController;

class AddMagazineController extends BaseController
{
    /**z
     * 添加杂志
     */
    public function index ()
    {
        $magazine_id=$_POST['magazine_id'];
        $page=$_POST['page'];
        $mokuai=$_POST['mokuai'];
        $miaoshu=$_POST['desc'];
        $title=$_POST['title'];
        $user_id=$_POST['user_id'];
        if (!$magazine_id) {
            $errMessage = [
                'code' => 1,
                'message' => 'magazine_id参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        if (!$page) {
            $errMessage = [
                'code' => 1,
                'message' => 'page参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        if (!$mokuai) {
            $errMessage = [
                'code' => 1,
                'message' => 'mokuai参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        if (!$miaoshu) {
            $errMessage = [
                'code' => 1,
                'message' => 'miaoshu参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        if (!$title) {
            $errMessage = [
                'code' => 1,
                'message' => 'title参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        if (!$user_id) {
            $errMessage = [
                'code' => 1,
                'message' => 'user_id参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
    	$model=D('magazine_detail');
            $data=[
                'page'=>$page,
                'mokuai'=>$mokuai,
                'moban'=>1,
                'description'=>$miaoshu,
                'magazine_id'=>$magazine_id,
                'title'=>$title,
                'user_id'=>$user_id
            ];
            $savemokuia1=$model->add($data);
             $this->ajaxReturn($savemokuia1);
    }
}