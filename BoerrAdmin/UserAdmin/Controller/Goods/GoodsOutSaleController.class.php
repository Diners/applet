<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/14 0014
 * Time: 17:34
 */

namespace UserAdmin\Controller\Goods;

use Common\Controller\BaseController;
use UserAdmin\Model\GoodsModel;

class GoodsOutSaleController extends BaseController
{
    public function index ()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');

        $goodsId = I('post.goods_id', 0, 'intval');
        if (!$goodsId) {
            $this->ajaxReturn('商品id不能为空！');
        }

        $goodsModel = new GoodsModel();
        $data = [
            'is_on_sale' => 1,
        ];
        // 下架操作
        $result = $goodsModel->saveGoods($goodsId, $data);
        if (!$result) {
            $this->ajaxReturn('商品下架失败！');
        } else {
            $this->ajaxReturn('true');
        }
    }
}