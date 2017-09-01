<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/7/18 0018
 * Time: 10:46
 */

namespace Home\Model;


use Common\Model\BaseModel;

class MagazineModel extends BaseModel
{
    public function saveMagazineCover ($magazineId,$url)
    {
        if (!$magazineId || !$url) {
            \Think\Log::write('文章图片model参数不能为空！');
            return flase;
        }
        $result = $this->where("magazine_id = {$magazineId}")->save(['magazine_cover' => $url]);
        return $result;
    }
}