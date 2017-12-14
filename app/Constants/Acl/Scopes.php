<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/30
 * Time: 下午12:18
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Constants\Acl;


class Scopes
{
    /**
     * 公用,无需登录验证
     */
    const SCOPES_UNAUTHORIZED = "unauthorized";
    /**
     * 普通用户
     */
    const SCOPES_COMMON_USERS = "common_user";
    /**
     * 平台用户
     */
    const SCOPES_MANAGER_USERS = "manager_user";
    /**
     * 系统管理员
     */
    const SCOPES_SUPER_USERS = "super_user";

}