<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:44
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Mvc;
use App\Constants\ErrorCode;
use App\Controller\ControllerBase;
use Phalcon\Annotations\Annotation;
use Phalcon\Annotations\Collection;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use Phalcon\Mvc\Micro;
use Phalcon\Annotations\Reflection;
use ReflectionClass;

class EndPointManager
{
    /**
     * @var Micro
     */
    protected $app ;
    protected $stack;

    public function __construct(Micro $app)
    {
        $this->app = $app;
        $this->stack =null;
    }

    public function add(... $classNames)
    {
        $this->stack = $classNames;
    }

    public function run() :void
    {
        $arr = $this->stack;
        if(!empty($arr)){
            foreach ($arr as $item){
                if(!is_string($item)){
                    throw new EndPointException(ErrorCode::POST_DATA_INVALID,'数据异常');
                }
                $this->createPoint($item);
            }
        }
    }


    /**
     * @param string $controllerName
     * @return mixed
     * @throws EndPointException
     * @internal param string $controller 控制器名
     * @internal param string $controllerName
     */
    public function createPoint(string $controllerName){
        $instance = $this->getControllerInstance($controllerName);

        $reflector = $this->getReflection($controllerName);
        $actions = $this->getActions($reflector);
        $controller = $this->getController($reflector);

        $collection = new MicroCollection();
        $collection->setHandler($instance);

        if($controller){
            $urlPrefix = $this->getUrlPrefix($controller);
            $collection->setPrefix($urlPrefix);
        }
        if($actions){  //Todo 完成其他请求方式
            foreach ($actions as $name =>$point ){

                $mapping = $this->getMapping($point);
                $method = $this->getMethod($mapping);
                $path = $this->getPath($mapping);
                if(!$path){
                    throw new EndPointException(ErrorCode::POST_DATA_INVALID,"路由配置错误");
                }
                if($method == "get"){
                    $collection->get($path,$name);
                }
                if($method == "post"){
                    $collection->post($path,$name);
                }
            }
        }
        $this->app->mount($collection);
    }



    public function getController(Reflection $reflection){
        $controller = $reflection->getClassAnnotations();
        return $controller;
    }

    public function getActions(Reflection $reflection):array
    {
        $points = $reflection->getMethodsAnnotations();
        return $points;
    }

    public function getUrlPrefix(Collection $collection ){
        return ($collection->has("url_prefix")) ? $collection->get("url_prefix")->getArgument("value") :"/";
    }
    /**
     * @param string $className
     * @return Reflection
     */
    public function getReflection(string $className):Reflection
    {
        $reader = new MemoryAdapter();
        $reflector = $reader->get($className);
        return $reflector;
    }

    public function getControllerInstance(string $className){
        $oReflectionClass = new ReflectionClass($className);
        $instance =  $oReflectionClass->newInstance();
       // $instance = new $className;
        if(!$instance instanceof ControllerBase){
            throw new EndPointException(ErrorCode::POST_DATA_INVALID,'Must Be Controller!');
        }
        return $instance;
    }

    protected function getMethod(Annotation $annotation):string
    {
        $method = $annotation->getArgument("method") ?? "get";
        return $method;
    }

    protected function getMapping(Collection $collection):Annotation
    {
        if($collection->has("Mapping")){
            return $collection->get("Mapping");
        }
    }

    protected function getPath(Annotation $annotation){
        $path = $annotation->getArgument('path');
        return $path;
    }

}