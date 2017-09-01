<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/20 0020
 * Time: 11:44
 */

namespace Home\Model;


use Common\Model\BaseModel;

class CommunityArticleImageModel extends BaseModel
{
    /**
     * 插入图片
     * @param $articleId int 文章id
     * @param $imageUrl string 图片url
     * @param $thumbUrl string 缩略图url
     * @return bool
     */
    public function setImage ($articleId, $imageUrl, $thumbUrl)
    {
        if (!$articleId || (!$thumbUrl && !$imageUrl)) {
            \Think\Log::write('文章图片model参数不能为空！');
            return flase;
        }
        $data = [
            'article_id' => $articleId,
            'thumb_url' => $thumbUrl,
            'image_url' => $imageUrl
        ];
        $this->add($data);
        return true;
    }

    /**
     * 获得单个图片
     * @param $articleId int 文章id
     * @return string 图片url
     */
    public function getImage ($articleId)
    {
        if (!$articleId) {
            \Think\Log::write('文章图片model参数不能为空！');
            return flase;
        }

        $image = $this->where("article_id = {$articleId}")->find();
        return $image['thumb_url'];
    }

    /**
     * 获得该文章id下所有图片
     * @param $articleId
     * @return mixed
     */
    public function getImages ($articleId)
    {
        if (!$articleId) {
            \Think\Log::write('文章图片model参数不能为空！');
            return flase;
        }

        $image = $this->where("article_id = {$articleId}")->select();
        return $image;

    }

}