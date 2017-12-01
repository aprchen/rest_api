<?php
namespace App\BootStrap;

use App\Component\ApiException;
use App\Component\ExceptionManager;
use App\Constants\ErrorCode;
use App\Mapper\BootstrapInterface;
use App\Middleware\CORSMiddleware;
use App\Middleware\FirewallMiddleware;
use App\Middleware\OptionsResponseMiddleware;
use App\Middleware\ResponseMiddleware;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Http\Request;
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

    /**
     * @param Micro $app
     * @param FactoryDefault $di
     * @param Config $config
     *
     */
    public function run(Micro $app, FactoryDefault $di, Config $config)
    {
        //注册中间件到事件管理器
        $eventsManager = new Manager();
        $eventsManager->attach("micro", new CORSMiddleware());
        $eventsManager->attach("micro", new FirewallMiddleware());
        $eventsManager->attach("micro", new OptionsResponseMiddleware());
        $app->setEventsManager($eventsManager);

        /**
         * 页面未找到
         */
        $app->notFound(function (){
            throw new ApiException(ErrorCode::ROUTE_NOT_FOUND);
        });
        /**
         * 异常捕捉
         * call_user_func
         */
        $app->error(function (\Throwable $t)use($app){
            if ($t instanceof ApiException) {
                switch ($t->getCode()) {
                    case ErrorCode::ROUTE_NOT_FOUND:
                        $app->response->redirect('error404');
                        break;
                    default:
                        $app->response->redirect('error500');
                        break;
                }
            }
        });
    }
}