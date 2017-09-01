<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:14
 */

namespace Home\Controller\Magazine;


use Common\Controller\BaseController;

class MagazineDetail2Controller extends BaseController
{
        public function index ()
        {
        	$userId = I('post.user_id');
            $page=$_POST['page'];
            $magazine_id=$_POST['magazine_id'];
            $mokuai=$_POST['mokuai'];
            $find1=M('Magazine_detail')->where("magazine_id='{$magazine_id}' && mokuai='{$mokuai}' && page={$page}")->find();
            $this->ajaxReturn($find1);
        }

}