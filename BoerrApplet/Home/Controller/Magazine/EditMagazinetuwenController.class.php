<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:13
 */

namespace Home\Controller\Magazine;

use Common\Controller\BaseController;

class EditMagazinetuwenController extends BaseController
{
    /**z
     * 修改杂志图文页杂志
     */
    public function index ()
    {
    	$model=M('magazine_detail');
        $mokuai=$_POST['mokuai'];
        $page=$_POST['page'];
    	$magazine_id=$_POST['magazine_id'];
            $data['title']=$_POST['title'];
            $data['description']=$_POST['desc'];
        $data['created']=time();
		$savemokuia=$model->where("magazine_id='{$magazine_id}' && page='{$page}' && mokuai='$mokuai' ")->save($data);
		$id = $model->where("magazine_id='{$magazine_id}' && page='{$page}' && mokuai='$mokuai' ")->find()['id'];
		 if (empty($savemokuia)) {
                $errMessage = [
                    'code' => 0,
                    'message' => '修改失败'
                ];
                $this->ajaxReturn($errMessage);
                return false;
        }
		        $result=[
					'code' => 1,
                    'message' => '修改成功'
		        ];
        $this->ajaxReturn($id);
    }
}