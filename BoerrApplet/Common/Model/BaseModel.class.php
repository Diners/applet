<?php

namespace Common\Model;

use Think\Model;

define('STATUS', " status < 3"); // 记录状态小于三
define('CREATED', " created = ".time()); // 记录创建时间
define('UPDATE', " UPDATE = ".time()); // 记录更新时间
define('LIKE_STATUS', 1); // 点赞状态
define('CANCEL_LIKE_STATUS', 0); // 取消点赞状态
define('JOIN_STATUS', 1); // 加入社群状态
define('CANCEL_JOIN_STATUS', 0); // 推出社群状态
define('IS_ON_SALE', " is_on_sale = 0"); // 推出社群状态
// 订单常量
define('ORDER_NON_PAY', 1); // 未付款
define('ORDER_NON_SEND', 2); // 未发货
define('ORDER_SEND', 3); // 已发货
define('ORDER_RECEIVE', 4); // 已收货
define('ORDER_NON_PAYMENT', 1); // 支付订单未支付
define('ORDER_PAYMENT', 2); // 支付订单已支付
// 商品图片状态
define('GOODS_IMAGE_TYPE3', 3); // 轮播图
define('GOODS_IMAGE_TYPE2', 2); // 商品详情图


class BaseModel extends Model
{

}