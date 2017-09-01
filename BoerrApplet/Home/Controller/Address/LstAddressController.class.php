<?php
namespace Home\Controller\Address;

use Common\Controller\BaseController;

class LstAddressController extends BaseController
{
    //地址管理列表
    public function index()
    {
        $user_id = $_POST['user_id'];
        $model = M('address');
        //select方法分别获取地址是否是默认地址，取出所有对应user_id的地址；
        $data = $model->where("user_id='{$user_id}' and user_imp=0")->order('address_id desc')->select();
        $data1 = $model->where("user_id='{$user_id}' and user_imp=1")->find();
        if(!empty($data1)){
                $result['address'][0]=$data1;
                foreach ($data as $k=>$v){
                    $i=$k+1;
                    $result['address'][$i]=$data[$k];
                }
        }else{
            $result['address'] = $data;
        }

            $result['code'] = 1;
        echo json_encode($result);
    }
}