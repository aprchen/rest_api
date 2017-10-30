<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/30
 * Time: 下午12:18
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Constants;


class Acl
{
    /**
     * 公用,无需登录验证
     */
    const SCOPES_PUBLIC = "public";
    /**
     * 注册用户
     */
    const SCOPES_COMMON_USERS = "common_users";
    /**
     * 会员
     */
    const SCOPES_VIP_USERS = "vip_users";
    /**
     * 管理员
     */
    const SCOPES_SUPER_USERS = "super_users";

}