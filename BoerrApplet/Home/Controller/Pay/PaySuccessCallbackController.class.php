<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/4 0004
 * Time: 15:12
 */

namespace Home\Controller\Pay;

use Common\Controller\BaseController;
use Home\Model\BankModel;
use Home\Model\CashRecordModel;
use Home\Model\OrderModel;
use Home\Model\OrderPayModel;

class PaySuccessCallbackController extends BaseController
{
    // 支付成功回掉接口
    public function index ()
    {
        $orderPayId = I('post.order_pay_id', 0, 'intval');
        $addressId = I('post.address_id', 0, 'intval');
        $userId = I('post.user_id', 0, 'intval');
        $couponId = I();

        if (!$orderPayId || !$addressId || !$userId) {
            $errMessage = [
                'code' => 1,
                'message' => '提交参数不能为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 查看订单是否存在
        $orderPayModel = new OrderPayModel();
        $orderModel = new OrderModel();
        $cashModel = new CashRecordModel();
        $bankModel = new BankModel();
        $orderPayInfo = $orderPayModel->getOrderPay($orderPayId);
        if (!$orderPayInfo) {
            $errMessage = [
                'code' => 2,
                'message' => '支付订单不存在！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 添加提现记录
        $cashModel->addCashStatus($userId, $orderPayId, $orderPayInfo['total_fee']);

        // 获得bank表记录，如果没有插入
        $bankInfo = $bankModel->getBank($userId);
        if (!$bankInfo) {
            $insertData = [
                'user_id' => $userId,
                'update' => time()
            ];
            $bankId = $bankModel->insertBank($insertData);
            if (!$bankId) {
                $errMessage = [
                    'code' => 3,
                    'message' => '插入bank表失败！'
                ];
                $this->ajaxReturn($errMessage);
                return false;
            }
        }

        // 修改支付订单状态
        $orderPayStatus = $orderPayModel->updatePayStatus($orderPayId);

        if (!$orderPayStatus) {
            $errMessage = [
                'code' => 3,
                'message' => '修改支付订单状态失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        // 修改品牌订单状态
        $orderStatus = $orderModel->updateOrderPayStatus($orderPayId, $addressId);

        if (!$orderStatus) {
            $errMessage = [
                'code' => 4,
                'message' => '修改订单状态失败！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $this->ajaxReturn('true');
        return true;
    }
}