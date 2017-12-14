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
use App\Component\Core\ApiCollection;
use App\Component\Core\App;
use App\Controller\DefaultController;
use App\Controller\OauthController;
use App\Controller\Resource\Resource;
use App\Controller\Resource\UsersResource;
use App\Controller\Resource\WechatResource;
use App\Controller\TestController;
use App\Controller\UserController;
use App\Controller\WeChatController;
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
        $app->mount(new ApiCollection(DefaultController::class))
            ->mount(new ApiCollection(Resource::class))
            ->mount(new ApiCollection(UsersResource::class))
            ->mount(new ApiCollection(OauthController::class))
            ->mount(new ApiCollection(WechatResource::class))
            ->mount(new ApiCollection(TestController::class))
            ->mount(new ApiCollection(WeChatController::class))
        ;
    }

}