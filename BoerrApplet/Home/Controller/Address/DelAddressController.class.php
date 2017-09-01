<?php
namespace Home\Controller\Address;

use Common\Controller\BaseController;

class DelAddressController extends BaseController
{
    //删除地址管理页面
    public function index()
    {
        $user_id = $_POST['user_id'];
        $model = M('address');
        $address_id = I('post.address_id');
        $del_address = $model->where("address_id='{$address_id}'")->delete();
        if (!empty($del_address)) {
            $result['code'] = 1;//删除成功
        } else {
            $result['code'] = 0;//删除失败
        }
        echo json_encode($result);
    }
}