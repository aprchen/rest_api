<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\BootStrap;


use App\Constants\Services;
use App\Controller\ControllerBase;
use App\Controller\UsersController;
use App\Mapper\BootstrapInterface;
use App\Mapper\Route;
use Phalcon\Annotations\Factory;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

class EndPointBootstrap implements BootstrapInterface
{


    public function run(Micro $app, FactoryDefault $di, Config $config)
    {
        $map = Route::map();
        $reader = new Reader();
        foreach ($map as $item){
            $parsing = $reader->parse($item);
            $class = new Reflection($parsing);
            foreach ($class->getReflectionData() as $datum){
                var_dump($datum);
                exit();
            }
        }

        $users = new MicroCollection();
        $users->setHandler(UsersController::class, true);
        $users->setPrefix('/users');
        $users->get('/get/{id}', 'get');
        $app->mount($users);
    }





}