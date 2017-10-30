<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:32
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Middleware;


use Phalcon\Annotations\Factory;
use Phalcon\Config;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * controller 执行之前发生
     *
     * @param Event $event
     * @param Micro $app
     * @return bool
     * @internal param Micro $application
     *
     */
    public function beforeExecuteRoute(Event $event, Micro $app)
    {
        $whiteList = $app->getDI()->getConfig()->whiteList;
        $controller = $app->getActiveHandler();
        var_dump($controller);
        exit();
        $ipAddress = $app->request->getClientAddress();
        if (true !== array_key_exists($ipAddress, $whiteList)) {
            $app->response->setStatusCode(401, 'Not ');
            $app->response->sendHeaders();

            $message = "当前ip无法访问";
            $app->response->setContent($message);
            $app->response->send();

            return false;
        }

        return true;
    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}