<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午6:25
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Constants;


class ErrorCode
{
    /**
     * 通用
     */
    const GENERAL_SYSTEM = 1010;
    const GENERAL_NOT_IMPLEMENTED = 1020;
    const GENERAL_NOT_FOUND = 1030;

    /**
     * 用户认证
     */
    const AUTH_INVALID_ACCOUNT_TYPE = 2010;
    const AUTH_LOGIN_FAILED = 2020;
    const AUTH_TOKEN_INVALID = 2030;
    const AUTH_SESSION_EXPIRED = 2040;
    const AUTH_SESSION_INVALID = 2050;

    /**
     * 访问控制
     */
    const ACCESS_DENIED = 3010;

    /**
     * 客户端错误
     */
    const DATA_FAILED = 4010;
    const DATA_NOT_FOUND = 4020;
    const ROUTE_NOT_FOUND = 4040;

    /**
     * 服务器错误
     */
    const POST_DATA_NOT_PROVIDED = 5010;
    const POST_DATA_INVALID = 5020;
    const END_GROUP_NOT_FOUND = 5030;
    const ENDPOINT_NOT_FOUND = 5031;
}