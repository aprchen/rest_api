<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午7:18
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Middleware;


use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class OptionsResponseMiddleware extends BaseMiddleware
{
    public function beforeHandleRoute(Event $event, Micro $app)
    {

    }

    public function call(Micro $api)
    {
        return true;
    }

}