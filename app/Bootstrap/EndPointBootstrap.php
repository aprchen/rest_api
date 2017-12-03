<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\BootStrap;

use App\Component\EndPointManager;
use App\Controller\DefaultController;
use App\Controller\TestController;
use App\Controller\UsersController;
use App\Controller\WeChat\IndexController;
use App\Mapper\BootstrapInterface;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

class EndPointBootstrap implements BootstrapInterface
{

    /**
     * @param Micro $app
     * @param FactoryDefault $di
     * @param Config $config
     * 路由注册
     */
    public function run(Micro $app, FactoryDefault $di, Config $config)
    {
        $config = $config->get("router");
        EndPointManager::getInstance($app)
            ->setCoreConfig($config)
            ->setLazy(EndPointManager::LAZY_LOAD)
            ->add(
                DefaultController::class,
                UsersController::class,
                TestController::class,
                IndexController::class   //微信
            )
            ->run();
    }

}