<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/29 0029
 * Time: 15:19
 */

namespace Home\Controller\SendMessage;

use Common\Controller\BaseController;
use Common\Lib\Alidayu\SendMsg;

class ChangeSendMessageController extends BaseController
{
    //用户的所有订单的列表

    //发送验证码
    public function index() {

        $alidayu = new SendMsg();
        $phone=$_POST['phone'];
        $user_id=$_POST['user_id'];

        //验证码
        $code = rand(100000, 999999);
        $model = M('Captche');
        $arr=array();
        $arr['captche']=$code;
        $arr['user_mobile']=$phone;
        $arr['user_id']=$user_id;
        $data = "{'code':'$code','product':'杂制杂志'}";
        $result = $alidayu->send($phone, $data);
        $result = json_decode(json_encode($result),true);
        // 查询是否存在手机号
        if ($result['result']['err_code'] === '0') {
            $find_shouji=$model->where("user_mobile='{$phone}'")->find();
            if(empty($find_shouji)){
                $add=$model->add($arr);
            }else{
                $arr1=array();
                $arr1['captche']=$code;
                $add=$model->where("user_mobile='{$phone}'")->save($arr1);
            }
            $result['code']=1;
            $result['message']='发送成功';
        } else {
            $result['code']=0;
            $result['message']='发送失败';
        }
        $this->ajaxReturn($result);
    }
}
