<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/29 0029
 * Time: 15:19
 */

namespace Home\Controller\SendMessage;

use Common\Controller\BaseController;

class CheckSendMessageController extends BaseController
{
    //发送验证码
    public function index() {
//接受登陆界面的用户id
        $code = I('post.code');
        $user_id = I('post.user_id');
        $phone = I('post.phone');
//实例化模型
        $model = M('Captche');
        $user = M('User');
        $data = $model->where("captche='{$code}' && user_mobile='{$phone}'")->find();
        if(!empty($data)){
                if($data['user_id'] !=$user_id){
                    $result['code']=3;
                    $result['message']='手机号码已被设置不能重复';
                    $this->ajaxReturn($result);
                }else{
                    $arr=array();
                    $arr['user_telephone']=$phone;
                    $add_phone = $user->where("user_id= '{$user_id}'")->save($arr);
                }

            if(!empty($add_phone)){
                $result['code']=1;
                $result['message']='手机号码设置成功';
                $result['user_mobile']=$phone;
                $this->ajaxReturn($result);
            }else {
                $result['code']=0;
                $result['message']='手机号码设置失败';
                $this->ajaxReturn($result);
            }
        } else{
            $result['code']=2;
            $result['message']='验证码错误';
            $this->ajaxReturn($result);
        }
    }
}