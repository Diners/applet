<?php

namespace Home\Controller\Upload;

use Common\Controller\BaseController;
use Home\Model\CommunityArticleImageModel;

class UploadCommunityImagesController extends BaseController
{
    // 上传社群图片
    public function index ()
    {
        $articleId = I('post.article_id', 0, 'intval');
        // 参数为空报错
        if (!$articleId) {
            $errMessage = [
                'code' => 1,
                'message' => '上传社群图片参数为空！'
            ];
            $this->ajaxReturn($errMessage);
            return false;
        }
        $imageModel = new CommunityArticleImageModel();
        // 获取当前模块图片配置文件
        $imageConf = C('ARTICLE_IMAGE_CONF');
        // 上传图片
        $info = $this->uploadImages($imageConf);
        // 数据入库
        $imageModel->setImage($articleId,'',$info);
        $this->ajaxReturn('true');
        return true;
    }
}