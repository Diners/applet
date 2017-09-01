<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/29 0029
 * Time: 15:19
 */

namespace Home\Controller\express;

use Common\Controller\BaseController;
use Common\Lib\soopy;

class ShowExpressController extends BaseController
{
    //用户的所有订单的列表

    //发送验证码
    public function index() {

        $typeNu = $_POST["express_num"];//快递号
        $AppKey = '29833628d495d7a5';//查询快递单记录的key
        $queryComKey = 'fBFHsUTb1813';//查询快递单号属于哪家公司的key

        $uri = 'http://www.kuaidi100.com/autonumber/auto?num=' . $typeNu . '&key=' . $queryComKey;
        $powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
        $typeCom = http_get($uri);
        if (empty($typeCom)) {
            $return['code'] = 0;
            $return['msg'] = '无效的快递单号,请重新输入!';
            echo json_encode($return);
        }
        $typeCom = json_decode($typeCom, 1);
        if (sizeof($typeCom)) {
            foreach ($typeCom as $k => $v) {
                // if(!in_array($v['comCode'])){
                //     $return['code']=0;
                //     $return['msg']='无效的快递公司';
                // }
                $com = $v['comCode'];
                $url = 'http://api.kuaidi100.com/api?id=' . $AppKey . '&com=' . $com . '&nu=' . $typeNu . '&show=0&muti=1&order=desc';
                $info = http_get($url);
                $info = json_decode($info, 1);
                switch ($info['state']) {
                    case 2:
                        $return['code'] = 0;
                        $return['msg'] = '快递100接口出现异常';
                        break;
                    case 1:
                        $return['code'] = 1;
                        $return['msg'] = '物流单暂无结果';
                        break;
                    case 3:
                        $return['code'] = 1;
                        $return['msg'] = $info['data'];
                        break;
                }
                $arr['code'] = $return['code'];
                $arr[$k] = $return['msg'];
            }
        }
        $result['code']=$arr['code'];
        $result['express']=$arr[0];
        $this->ajaxReturn($result);
    }
}
