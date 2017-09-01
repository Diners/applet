<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model;
class IndexController extends Controller {
    public function index(){
        $goodsModel = new Model\GoodsModel();
        $list = $goodsModel->getGoodsList();
        var_dump($list);
    }
}