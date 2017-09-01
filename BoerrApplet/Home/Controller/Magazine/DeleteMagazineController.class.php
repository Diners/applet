<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:17
 */

namespace Home\Controller\Magazine;


use Common\Controller\BaseController;

class DeleteMagazineController extends BaseController
{
        public function index ()
    {
    	$model=M('magazine_detail');
    	$page=$_POST['page'];
    	$magazine_id=$_POST['magazine_id'];
    	// $pagesearch=$page+1;
		$pages=$model->where("magazine_id='{$magazine_id}'")->field('page')->select();
		foreach($pages as $k=>$v){
			$pages1[]=$pages[$k]['page'];
		}	
		$ever=array_unique($pages1);
		$ever1=max($ever);
		//以上的代码是找出当前用户的最大的页码，进行操作，保证插入成功。
		$delmokuia=$model->where("page={$page}")->delete();
		for ($i=$page; $i <=$ever1 ; ++$i) { 
			$data1=[
				page=>$i-1
			];
			$pagechange[]=$model->where("magazine_id='{$magazine_id}' && page='{$i}'")->save($data1);
		};
		
		 if (empty($delmokuia)) {
                $errMessage = [
                    'code' => 0,
                    'message' => '删除失败'
                ];
                $this->ajaxReturn($errMessage);
                return false;
        }
		        $result=[
					'code' => 1,

                    'message' => '删除成功'
		        ];
        $this->ajaxReturn($result);
    }
}