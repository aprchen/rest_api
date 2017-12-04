<?php
namespace App\Constants\Http;
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/4
 * Time: 下午6:54
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class Methods
{
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";
    const HEAD = "HEAD";
    const OPTIONS = "OPTIONS";
    const PATCH = "PATCH";

    static $ALL_METHODS = [self::GET, self::POST, self::PUT, self::DELETE, self::HEAD, self::OPTIONS, self::PATCH];
}