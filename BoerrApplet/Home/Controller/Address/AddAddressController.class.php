<?php
namespace Home\Controller\Address;

use Common\Controller\BaseController;

class AddAddressController extends BaseController
{
    //添加收货地址
    public function index()
    {
        $user_id = $_POST['user_id'];
        $model = M('address');
        $user_imp = $_POST['user_imp'];
        if ($user_imp == 1) {
            $data1 = $model->where("user_imp=1 && user_id={$user_id}")->find();
            if(!empty($data1)){
                $data11['user_imp'] = 0;
                $datal23 = $model->where("address_id={$data1['address_id']}")->save($data11);
            }
        }
            //3、实例化模型
            $arr = array();
            $arr['user_id'] = $user_id;
            $arr['user_rec_name'] = I('post.names');
            $arr['user_rec_mobile'] = I('post.phones');
            $arr['user_address'] = I('post.user_address');
            $arr['user_detail_addr'] = I('post.detail');
            $arr['user_imp'] = $user_imp;
            $add_address = $model->add($arr);
        if (!empty($add_address)) {
            $result['code'] = 1;
        } else {
            $result['code'] = 0;
        }
        echo json_encode($result);
    }
}