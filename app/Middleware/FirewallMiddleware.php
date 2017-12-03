<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:32
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Middleware;


use App\Component\EndPoint;
use App\Component\EndPointManager;
use App\Component\EndPointMap;
use App\Constants\Services;
use Phalcon\Config;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;

class FirewallMiddleware extends BaseMiddleware
{
    /**
     * controller 执行之前发生
     *
     * @param Event $event
     * @param Micro $app
     * @return bool
     * @internal param Micro $application
     * 有防火墙注解,且访问Ip在对应名单中,可以访问
     */
    public function beforeExecuteRoute(Event $event, Micro $app)
    {
        $activeHandler = $app->getActiveHandler();
        /** @var  $group Micro\LazyLoader */
        $controller = $activeHandler[0] ?? null;
        $action = $activeHandler[1] ?? null;
        $fire = "";
        if ($controller && $action) {
            $arr = EndPointManager::getInstance()->getEndPoints();
            /** @var  $endPoint EndPoint */
            $endPoint = $arr[$controller->getDefinition()];
            $group = $endPoint->getGroup();
            $point = $endPoint->getPoints()[$action];
            if (isset($group[EndPointMap::FIRE_WALL])) {
                $fire = $group[EndPointMap::FIRE_WALL];
            }else if(isset($point[EndPointMap::FIRE_WALL])){
                $fire = $point[EndPointMap::FIRE_WALL];
            }
        }
        if ($fire) {
            $ipAddress = $app->request->getClientAddress();
            /** @var  $config Config */
            $config = $app->getService(Services::CONFIG);
            $list = $config->get($fire) ?? null;

            if($list && count($list)>0){
                $list= $list->toarray();
                if(in_array($ipAddress,$list)){
                    return true;
                }
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