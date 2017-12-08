<?php
namespace App\BootStrap;

use App\Component\BootstrapInterface;
use App\Component\Core\App;
use App\Constants\Services;
use App\Middleware\AclMiddleware;
use App\Middleware\AuthTokenMiddleware;
use App\Middleware\CORSMiddleware;
use App\Middleware\FirewallMiddleware;
use App\Middleware\NotFoundMiddleware;
use App\Middleware\OptionsResponseMiddleware;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午4:42
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class MiddlewareBootstrap implements BootstrapInterface
{

    /**
     * @param App $app
     * @param FactoryDefault $di
     * @param Config $config
     *
     */
    public function run(App $app, FactoryDefault $di, Config $config)
    {
        /** @var  $eventsManager Manager */
        $eventsManager = $app->getService(Services::EVENTS_MANAGER);
        $eventsManager->attach("micro", new AuthTokenMiddleware());
        $eventsManager->attach("micro", new AclMiddleware());
        $eventsManager->attach("micro", new NotFoundMiddleware());
        $eventsManager->attach("micro", new CORSMiddleware());
        $eventsManager->attach("micro", new OptionsResponseMiddleware());
        $app->setEventsManager($eventsManager);
    }
}