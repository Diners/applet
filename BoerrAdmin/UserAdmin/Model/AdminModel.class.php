<?php
/**
 * Created by PhpStorm.
 * User: spring@boerr.cn
 * Date: 2017/8/11 0011
 * Time: 9:31
 */

namespace UserAdmin\Model;

use Common\Model\BaseModel;

class AdminModel extends BaseModel
{
    // 获得管理员信息
    public function getAdminInfo ($adminName, $md5Password)
    {
        $adminInfo = $this->where("admin_name = '{$adminName}' AND admin_password = '{$md5Password}'")->find();

        return $adminInfo;
    }

    // 插入用户信息
    public function setAdmin ($adminName, $md5Password, $brandId)
    {
        $addData = [
            'admin_name' => $adminName,
            'admin_password' => $md5Password,
            'brand_id' => $brandId,
            'status' => 1,
            'created' => time()
        ];
        $this->add($addData);
    }

    // 获得管理员信息,根据用户名
    public function getAdmin ($adminName)
    {
        $adminInfo = $this->where("admin_name = '{$adminName}'")->find();

        return $adminInfo;
    }
}