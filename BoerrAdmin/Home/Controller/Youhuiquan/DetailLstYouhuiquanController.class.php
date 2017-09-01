<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/2 0002
 * Time: 10:56
 */

namespace Home\Controller\Youhuiquan;

use Common\Controller\BaseController;
use Home\Model\AddressModel;
use Home\Model\GoodsBrandModel;
use Home\Model\GoodsImageModel;
use Home\Model\GoodsModel;
use Home\Model\GoodsStandardModel;
use Home\Model\OrderGoodsModel;
use Home\Model\OrderModel;
use Home\Model\OrderPayModel;

class DetailLstYouhuiquanController extends BaseController
{
    // 查看兑换码
    public function index()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $cuxiao = M("cuxiao");
        $brand = $_POST['shibie'];
        $data = $cuxiao->where("code='{$brand}' && state<3")->select();
        foreach ($data as $k => $v) {
            //0 未激活 1 已使用 2 已作废 3 已删除
            if ($v['state']==0){
                $result['message'][$k]['state'] = '未使用';//
            }else if ($v['state']==1){
                $result['message'][$k]['state'] = '已使用';//
            }else if ($v['state']==2){
                $result['message'][$k]['state'] = '已作废';//
            }
            $result['message'][$k]['num'] = $k+1;//序号
            $result['message'][$k]['mima'] = $v['mima'];//兑换码
        }
        $this->ajaxReturn($result);

    }
}