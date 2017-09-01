<?php
namespace Home\Controller\Address;

use Common\Controller\BaseController;

class ShowAddressController extends BaseController
{
    public function index()
    {
        $user_id = $_POST['user_id'];
        $model = M('address');
        $address_id = I('post.address_id');
        //选择要删除的这个地址;
        $data = $model->where("address_id='{$address_id}'")->find();
        $result['address']=$data;
        $result['code'] = 1;
        echo json_encode($result);
    }
}