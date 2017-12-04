<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\BootStrap;

use App\Component\BootstrapInterface;
use App\Component\Core\App;
use App\Controller\DefaultController;
use App\Controller\TestController;
use App\Controller\UsersController;
use App\Controller\WeChat\IndexController;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;

class EndPointBootstrap implements BootstrapInterface
{

    /**
     * @param App $app
     * @param FactoryDefault $di
     * @param Config $config
     * 路由注册
     */
    public function run(App $app, FactoryDefault $di, Config $config)
    {
        $app->setCoreConfig($config['router'])
            ->setLazy(App::LAZY_LOAD)
            ->add(
                DefaultController::class,
                UsersController::class,
                TestController::class,
                IndexController::class   //微信
            );
        $app->run();
    }

}