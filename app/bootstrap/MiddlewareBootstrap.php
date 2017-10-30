<?php
namespace App\BootStrap;
use App\Mapper\BootstrapInterface;
use App\Middleware\CORSMiddleware;
use App\Middleware\FirewallMiddleware;
use App\Middleware\NotFoundMiddleware;
use App\Middleware\OptionsResponseMiddleware;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午4:42
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class MiddlewareBootstrap implements BootstrapInterface
{

    public function run(Micro $app, FactoryDefault $di, Config $config)
    {

        $eventsManager = new Manager();

        $eventsManager->attach("micro",new NotFoundMiddleware());
        /** @var NotFoundMiddleware */
        $app->before(new NotFoundMiddleware());

        $eventsManager->attach("micro",new CORSMiddleware());
        /** 跨域 */
        $app->before(new CORSMiddleware());

        $eventsManager->attach("micro",new FirewallMiddleware());
        /** ip限制 */
        $app->before(new FirewallMiddleware());

        $eventsManager->attach("micro",new OptionsResponseMiddleware());
        /** option 请求回复 */
        $app->before(new OptionsResponseMiddleware());

        $app->setEventsManager($eventsManager);
    }
}