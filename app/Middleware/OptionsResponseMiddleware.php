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

class OptionsResponseMiddleware implements MiddlewareInterface
{
    public function beforeHandleRoute(Event $event, Micro $app)
    {
        $request = new Request();
        // OPTIONS request, just send the headers and respond OK
        if ($request->isOptions()) {
            $app->response->setJsonContent([
                'result' => 'OK',
            ]);
            return false;
        }
    }

    public function call(Micro $api)
    {
        return true;
    }
}