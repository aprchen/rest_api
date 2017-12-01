<?php
namespace App\Middleware;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:22
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class NotFoundMiddleware implements MiddlewareInterface
{

    /**
     * The route has not been found
     *
     * @param Event $event
     * @param Micro $app
     * @return bool
     * @internal param Micro $application
     */
    public function beforeNotFound(Event $event, Micro $app)
    {
        $app->response->setStatusCode(404, 'Not Found');
        $app->response->sendHeaders();
        //$app->response->redirect('error404');
        $app->response->send();
        return false;
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