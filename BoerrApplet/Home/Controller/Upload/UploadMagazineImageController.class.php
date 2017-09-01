<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/27 0027
 * Time: 19:30
 */

namespace Home\Controller\Upload;

use Common\Controller\BaseController;
use Home\Model\MagazineDetailModel;

class UploadMagazineImageController extends BaseController
{
    public function index ()
    {
        $magazineId = I('post.magazine_id', 0, 'intval');
        // 参数为空报错
        if (!$magazineId) {
            $errMessage = [
                'code' => 1,
                'message' => '上传社群图片参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $imageModel = new MagazineDetailModel();
        // 获取当前模块图片配置文件
        $imageConf = C('FENGMIAN_IMAGE_CONF');
        // 上传图片
        $info = $this->uploadImages($imageConf);
        // 数据入库
        $result = $imageModel->setImage($magazineId,$info);
        $this->ajaxReturn($result);
        return true;
    }
}