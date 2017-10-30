<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:32
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Middleware;


use App\Constants\Services;
use Phalcon\Annotations\Factory;
use Phalcon\Config;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * controller 执行之前发生
     *
     * @param Event $event
     * @param Micro $app
     * @return bool
     * @internal param Micro $application
     * 用法,在对应 controller 的 方法注释中 添加 @Firewall;
     *
     */
    public function beforeExecuteRoute(Event $event, Micro $app)
    {
        $whiteList = $app->getDI()->getConfig()->whiteList->toArray();
        $activeHandler = $app->getActiveHandler();
        $controller = $activeHandler[0] ?? null;
        $action = $activeHandler[1] ?? null;
        $flag = false;
        if($controller&& $action){
            $reader = new MemoryAdapter();
            $annotations = $reader->get($controller);
            $flag = $annotations->getMethodsAnnotations()[$action]->has("Firewall");
        }
        if($flag){
            $ipAddress = $app->request->getClientAddress();
            if (!array_search($ipAddress, $whiteList)>0) {
                $app->response->setStatusCode(401, 'Not Allowed');
                $app->response->sendHeaders();

                $message = "当前ip无法访问";
                $app->response->setContent($message);
                $app->response->send();

                return false;
            }
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