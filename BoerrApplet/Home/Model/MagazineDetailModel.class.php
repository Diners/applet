<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/27 0027
 * Time: 19:47
 */

namespace Home\Model;


use Common\Model\BaseModel;

class MagazineDetailModel extends BaseModel
{
    public function setCover ($magazineId, $url)
    {
        if (!$magazineId || !$url) {
            \Think\Log::write('文章图片model参数不能为空！');
            return flase;
        }
        $result = $this->where("id = {$magazineId}")->save(['cover' => $url]);
        return $result;
    }

    public function setImage ($magazineId, $url)
    {
        if (!$magazineId || !$url) {
            \Think\Log::write('文章图片model参数不能为空！');
            return flase;
        }
        $result = $this->where("id = {$magazineId}")->save(['image' => $url]);
        return $result;
    }
}