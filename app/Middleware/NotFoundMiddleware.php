<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午7:18
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Middleware;


use App\Component\ApiException;
use App\Constants\ErrorCode;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class NotFoundMiddleware implements MiddlewareInterface
{
    public function beforeNotFound()
    {
        throw new ApiException(ErrorCode::DATA_NOT_FOUND);
    }

    public function call(Micro $api)
    {
        return true;
    }

}