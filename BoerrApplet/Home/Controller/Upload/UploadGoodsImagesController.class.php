<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/1 0001
 * Time: 15:18
 */

namespace Home\Controller\Upload;

use Common\Controller\BaseController;

class UploadGoodsImagesController extends BaseController
{
    public function index ()
    {

        $model = M('goods_image');
        // 获取当前模块图片配置文件
        $imageConf = C('GOODS_IMAGE_CONF');
        // 上传图片
        $info = $this->uploadImages($imageConf);
        // 数据入库
        $data = [
          'goods_id' => 1,
            'image_type' =>1,
            'thumb_url' => $info
        ];
        $model->add($data);
    }
}