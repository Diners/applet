<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/17 0017
 * Time: 19:13
 */

namespace Home\Controller\Magazine;

use Common\Controller\BaseController;

class CheckagentController extends BaseController
{
    /**z
     * 添加杂志
     */
    public function index ()
    {
    	$model=M('agent');
    	$user_id=$_POST['user_id'];
		$search_agent=$model->where("user_id='{$user_id}'")->find();
		 if (empty($search_agent)) {
                $errMessage = [
                    'code' => 0,
                    'message' => '不是代理不能使用该模版'
                ];
                $this->ajaxReturn($errMessage);
                return false;
        }else{
             $brand_id=$search_agent['brand_id'];
            $goods['goods_list']=M('goods')->where("brand_id='{$brand_id}' && is_on_sale=0")->select();
            foreach ($goods['goods_list'] as $k=>$v){
                $goods['goods_list'][$k]['image']=M("goods_image")->where("goods_id={$v['goods_id']} && img_type=1")->field("thumb_url")->find()['thumb_url'];
            }
            $goods['fenlei']=M('goods_category')->where("brand_id='{$brand_id}' && status<3")->field('cat_name,cat_id')->select();
            $goods['brand_id']=$brand_id;
            $this->ajaxReturn($goods);
         }
    }
}