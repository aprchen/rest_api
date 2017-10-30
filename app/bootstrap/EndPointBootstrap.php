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
use App\Controller\DefaultController;
use App\Controller\RoomController;
use App\Controller\UsersController;
use App\Mapper\BootstrapInterface;
use App\Mvc\EndPointException;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

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
        $this->createPoint(new DefaultController(),$app);
        $this->createPoint( new UsersController(),$app);
        $this->createPoint(new RoomController(),$app);
    }

    /**
     * @param Controller $controller
     * @param Micro $app
     * @return mixed
     * @throws EndPointException
     * @internal param string $controllerName
     * @todo 考虑用协程完善循环,分离出去
     */
    public function createPoint(Controller $controller,Micro $app){

        $reader = new MemoryAdapter();
        $reflector = $reader->get($controller);
        $points = $reflector->getMethodsAnnotations();
        $class = $reflector->getClassAnnotations();
        $collection = new MicroCollection();
        $collection->setHandler($controller);
        if($class){
            $value =($class->has("url_prefix")) ? $class->get("url_prefix")->getArgument("value") :"/";
            $collection->setPrefix($value);
        }
        foreach ($points as $name =>$point ){
            if($point->has("Mapping")){
                $path = $point->get("Mapping")->getArgument("path");
                $method = $point->get("Mapping")->getArgument("method");
                if(empty($path)){
                    throw new EndPointException("路由配置错误");
                }
                if($method =="get" or  $method ==null){
                    $collection->get($path,$name);
                }
                if($method == "post"){
                    $collection->post($path,$name);
                }
            }
        }
        $app->mount($collection);
    }




}