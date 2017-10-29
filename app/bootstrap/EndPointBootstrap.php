<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\BootStrap;


use App\Controller\UsersController;
use App\Mapper\BootstrapInterface;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;

class EndPointBootstrap implements BootstrapInterface
{

    public function run(Micro $app, FactoryDefault $di, Config $config)
    {
        $users = new MicroCollection();
        $users->setHandler(UsersController::class, true);
        $users->setPrefix('/users');
        $users->get('/get/{id}', 'get');
        $app->mount($users);
    }



}