<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:44
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component;

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Phalcon\Mvc\Micro;

/**
 * Class EndPointManager
 * @package App\Component
 * TODO 路由缓存
 */
class EndPointManager
{

    const LAZY_LOAD = true;
    const DEFAULT_PREFIX = "/";
    const METHOD_GET = "get";
    const METHOD_POST = "post";
    const METHOD_PUT = "put";
    const METHOD_DELETE = "delete";
    const METHOD_ALL = [self::METHOD_GET,self::METHOD_POST,self::METHOD_PUT,self::METHOD_DELETE];
    /**
     * @var Micro
     */
    protected static $app;
    /**
     * @var
     */
    protected $stack;
    /**
     * @var
     */
    protected $endPoints;
    /**
     * @var bool
     * 懒加载
     */
    protected $lazy = false;

    /**
     * @return mixed
     */
    public function getEndPoints()
    {
        return $this->endPoints;
    }

    /**
     * @param $name
     * @param mixed $endPoints
     */
    public function setEndPoints($name,$endPoints)
    {
        $this->endPoints[$name] = $endPoints;
    }

    /**
     * @var $instance EndPointManager;
     */
    protected static $instance;

    private $coreConfig;

    static function getInstance($app = null)
    {
        if (!isset(self::$instance)) {
            self::$instance = new static($app);
        }
        return self::$instance;
    }

    public function setCoreConfig($config)
    {
        $this->coreConfig = $config;
        return $this;
    }

    private function __construct($app)
    {
        if (empty(self::$app) && $app instanceof Micro) {
            self::$app = $app;
        }
    }

    public function add(... $classNames)
    {
        $this->stack = $classNames;
        return $this;
    }

    public function run(): void
    {
        Core::getInstance($this->coreConfig['annotations']);
        while (!empty($this->stack)) {
            $item = array_pop($this->stack);
            $endPoint = new EndPoint();
            $endPoint->setHandle($item)->initialize();
            $this->setEndPoints($item,$endPoint);
        }
        $this->mountAll();
    }

    /**
     * 端点挂载
     */
    protected function mountAll()
    {
        $endPoints = $this->getEndPoints();
        if (count($endPoints) > 0) {
            foreach ($endPoints as $point) {
                $this->mountPoint($point);
            }
        }
    }

    /**
     * @param EndPoint $point
     */
    public function mountPoint(EndPoint $point)
    {
        $group = $point->getGroup();
        $points = $point->getPoints();
        if (!$group && empty($points)) {
            return;
        }
        $collection = new MicroCollection();
        $lazy = $this->isLazy();
        $handle = $point->getHandle();
        if(!$lazy){ //非懒加载的话,获取handle实例
           $handle  = $point->getHandleInstance();
        }
        $collection->setHandler($handle, $lazy);
        $urlPrefix = $group[EndPointMap::PATH] ?? self::DEFAULT_PREFIX;
        $collection->setPrefix($urlPrefix);
        if ($points && count($points) > 0) {
            foreach ($points as $handle => $item) {
                $name = $item[EndPointMap::NAME] ?? null;
                $method = $item[EndPointMap::METHOD]?? self::METHOD_GET;
                $path = $item[EndPointMap::PATH] ?? false;
                if ($path && in_array($method,self::METHOD_ALL)) {
                    if(is_array($path)){
                        foreach ($path as $value){
                            $collection->$method($value,$handle,$name);
                        }
                    }else{
                         $collection->$method($path,$handle,$name);
                    }
                }
            }
        }
        self::$app->mount($collection);
    }

    protected function setPoint($path,$handle,$name,$method){

    }

    /**
     * @return bool
     */
    public function isLazy(): bool
    {
        return $this->lazy;
    }

    /**
     * @param bool $lazy
     * @return $this
     * 懒加载
     */
    public function setLazy(bool $lazy)
    {
        $this->lazy = $lazy;
        return $this;
    }

    /**
     * @return \Phalcon\Mvc\RouterInterface
     * 获取路由
     */
    public function getRouter(){
       return self::$app->getRouter();
    }

    /**
     * @return \Phalcon\Mvc\Router\RouteInterface[]
     * 查看路由
     */
    public function getRouterMap(){
        return self::$app->getRouter()->getRoutes();
    }
}