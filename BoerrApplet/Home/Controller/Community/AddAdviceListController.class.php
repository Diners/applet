<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/1 0001
 * Time: 14:22
 */

namespace Home\Controller\Community;

use Common\Controller\BaseController;

class AddAdviceListController extends BaseController
{
    public function index ()
    {
        $id = [
            1,2,3,4,5,6
        ];

        $id = serialize($id);

        $data = [
            'goods_suggest' => $id
        ];
        $Model = M('community');
        $a = $Model->where("community_id = 1")->save($data);
        var_dump($a);die;
    }
}