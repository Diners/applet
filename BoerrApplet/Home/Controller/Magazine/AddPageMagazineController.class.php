<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:13
 */

namespace Home\Controller\Magazine;

use Common\Controller\BaseController;

class AddPageMagazineController extends BaseController
{
    /**z
     * 添加杂志
     */
    public function index ()
    {
    	$model=M('magazine_detail');
    	$page=$_POST['page'];
    	$magazine_id=$_POST['magazine_id'];
		$pages=$model->where("magazine_id='{$magazine_id}'")->field('page')->select();
//		$user_id=$_POST['user_id'];
		foreach($pages as $k=>$v){
			$pages1[]=$pages[$k]['page'];
		}	
		$ever=array_unique($pages1);
		$ever1=max($ever);
		//以上的代码是找出当前用户的最大的页码，进行操作，保证插入成功。
        //如果模块=1.就新增3页；
            for ($i=$ever1; $i >=$page ; $i--) {
                $data11=[
                    page=>$i+1
                ];
                $pagechange[]=$model->where("magazine_id='{$magazine_id}' && page={$i}")->save($data11);
            };
                $result=1;
                $this->ajaxReturn($result);
    }
}