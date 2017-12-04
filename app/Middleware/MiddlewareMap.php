<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/1
 * Time: 下午5:33
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Middleware;


use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Interface MiddlewareMap
 * @package App\Middleware
 * 本接口不需要被实现,只是起提示作用,说明MiddlewareInterface 中有哪些方法可以使用
 * 下面的方法是可以在MiddlewareInterface中直接使用的
 */
interface MiddlewareMap extends MiddlewareInterface
{
    public function afterBinding(Event $event, Micro $app);
    /**
     * @param Event $event
     * @param Micro $app
     * @internal param Micro $application
     * @description 路由捕获之前
     */
    public function beforeHandleRoute(Event $event, Micro $app);
    /**
     * @param Event $event
     * @param Micro $app
     * @description 路由执行之前
     */
    public function beforeExecuteRoute(Event $event, Micro $app);
    /**
     * @param Event $event
     * @param Micro $app
     * @description 未找到
     */
    public function beforeNotFound(Event $event, Micro $app);
    public function afterExecuteRoute(Event $event, Micro $app);
    /**
     * @param Event $event
     * @param Micro $app
     */
    public function afterHandleRoute(Event $event, Micro $app);
    /**
     * @param Micro $app
     * 如果你的方法需要整个生命周期都生效的话
     * Before anything happens
     * @return bool
     * 这里为程序回调,上面的为事件回调,在事件管理器中生效的话,请使用上面的方法
     */
    public function call(Micro $app);

}