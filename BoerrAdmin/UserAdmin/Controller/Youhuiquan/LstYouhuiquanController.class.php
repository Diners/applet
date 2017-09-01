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

class LstYouhuiquanController extends BaseController
{
    // 促销活动列表
    public function index()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');

        $activitylist = M("Activitylist");
        $brand = $_POST['brand_id'];
        $data = $activitylist->where("brand='{$brand}' && state<3")->select();
        foreach ($data as $k => $v) {
            $goods[$k] = $v['goods_id'];
            if (empty($goods[$k])) {
                $result['message'][$k]['fanwei'] = '所有商品';
            } else {
                $goodsMessage[$k] = M('goods')->where("goods_id='{$goods[$k]}'")->find();
                $result['message'][$k]['fanwei'] = $goodsMessage[$k]['goods_name'];
            }
            $result['message'][$k]['name'] = $v['activity_label'];
            $result['message'][$k]['guize'] = '满' . $v['money'] . '减' . $v['discount'];
            $result['message'][$k]['time'] = date("Y-m-d", $v['created_time']) . '—' . date("Y-m-d H:i:s", $v['end_time']);
            $result['message'][$k]['count'] = $v['count'];//开卡数量
            $result['message'][$k]['shibie'] = $v['code'];//
        }
        $this->ajaxReturn($result);

    }
}