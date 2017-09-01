<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 14:33
 */

namespace Home\Controller\Login;


use Common\Controller\BaseController;
use Home\Model\UserModel;

class WxLoginController extends BaseController
{
    public function index ()
    {
        $code = I('get.code', '' , 'trim'); // code
        if (!$code) {
            $errMessage = [
                'code' => 1,
                'message' => 'code为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $api = C('WX_LOGIN_URL');
        $appId = C('APP_ID');
        $appSecret = C('APP_SECRET');
        $grandType = C('GRAND_TYPE');
        // 拼接接口url
        $url = $api.'?appid='.$appId.'&secret='.$appSecret.'&js_code='.$code.'&grant_type='.$grandType;
        // 请求微信接口
        $request = $this->getRequest($url);
        $request = (array)json_decode($request);

        if (!$request['openid']) {
            $errMessage = [
                'code' => 1,
                'message' => $request['errmsg'],
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }

        $userModel = new UserModel();
        $userInfo = $userModel->getUserByOpenId($request['openid']);
        if (!$userInfo) {
            $Message = [
                'code' => 0,
                'message' => '用户信息为空，请获得用户信息并提交！',
                'openid' => $request['openid']
            ];
            $this->ajaxReturn($Message);
            return true;
        }

        $result = [];
        $result['user_message']['user_id'] = $userInfo['user_id'];
        $result['user_message']['user_name'] = $userInfo['user_name'];
        $result['user_message']['openid'] = $userInfo['openid'];
        $result['user_message']['user_sex'] = $userInfo['user_sex'];
        $result['user_message']['user_mobile'] = $userInfo['user_mobile'];
        $result['user_message']['user_head'] = $userInfo['user_head'];
        $this->ajaxReturn($result);
        return true;

    }

}