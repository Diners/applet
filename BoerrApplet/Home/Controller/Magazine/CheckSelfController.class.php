<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:13
 */

namespace Home\Controller\Magazine;

use Common\Controller\BaseController;

class CheckSelfController extends BaseController
{
    /**z
     * 看看是本人的杂志还是别人的杂志
     */
    public function index ($magazine_id,$user_id)
    {
    	$model=M('Magazine');
    	$model1=M('Magazine_detail');
   		$data=M('Magazine')->where("magazine_id='{$magazine_id}'")->field("user_id")->find();
		if($user_id==$data){
			$result=1;
		}else{
			$shoucang=M('Magazine_like')->where("magazine_id='{$magazine_id}'")->count();
			$result=0;
		}
   return $result;
    	
    }
}