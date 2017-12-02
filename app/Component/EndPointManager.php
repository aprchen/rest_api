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
class EndPointManager
{

    const LAZY_LOAD = true;
    const DEFAULT_PREFIX = "/";
    const METHOD_GET = "get";
    const METHOD_POST = "post";
    const METHOD_PUT = "put";
    const METHOD_DELETE = "delete";

    /**
     * @var Micro
     */
    protected $app ;
    /**
     * @var
     */
    protected $stack;
    /**
     * @var
     */
    protected $endPoints;

    /**
     * @return mixed
     */
    public function getEndPoints()
    {
        return $this->endPoints;
    }

    /**
     * @param mixed $endPoints
     */
    public function setEndPoints($endPoints)
    {
        $this->endPoints[] = $endPoints;
    }

    /**
     * @var $instance EndPointManager;
     */
    protected static $instance;

    private $coreConfig;

    static function getInstance(Micro $app){
        if(!isset(self::$instance)){
            self::$instance = new static($app);
        }
        return self::$instance;
    }

    public function setCoreConfig($config){
        $this->coreConfig = $config;
        return $this;
    }

    private function __construct(Micro $app)
    {
        $this->app = $app;
    }

    public function add(... $classNames)
    {
        $this->stack = $classNames;
    }

    public function run() :void
    {
        Core::getInstance($this->coreConfig);

        while (!empty($this->stack)){
            $item = array_pop($this->stack);
            $endPoint = new EndPoint();
            $endPoint->setHandle($item)->initialize();
            $this->setEndPoints($endPoint);
        }
        $this->mountAll(false);
    }

    /**
     * 端点挂载
     * @param bool $lazy
     */
    protected function mountAll($lazy = false)
    {
        $endPoints = $this->getEndPoints();
        if(count($endPoints)>0){
            foreach ($endPoints as $point){
                $this->mountPoint($point,$lazy);
            }
        }
    }

    /**
     * @param EndPoint $point
     * @param bool $lazy
     * TODO 路由做缓存
     */
    public function mountPoint(EndPoint $point,$lazy = false){
        $group = $point->getGroup();
        $points = $point->getPoints();
        if(!$group&&empty($points)){
            return;
        }
        $collection = new MicroCollection();
        $collection->setHandler($point->getHandleInstance(),$lazy);
        $urlPrefix = $group[EndPointMap::PATH] ?? self::DEFAULT_PREFIX;
        $collection->setPrefix($urlPrefix);
        if($points && count($points)>0){
            foreach ($points as $name =>$item ){
                $method = $item[EndPointMap::METHOD]?? self::METHOD_GET;
                $path = $item[EndPointMap::PATH] ?? false;
                if($path){
                    if($method == self::METHOD_GET){
                        $collection->get($path,$name);
                    }
                    if($method == self::METHOD_POST){
                        $collection->post($path,$name);
                    }
                    if($method == self::METHOD_PUT){
                        $collection->put($path,$name);
                    }
                    if($method == self::METHOD_DELETE){
                        $collection->delete($path,$name);
                    }
                }
            }
        }
        $this->app->mount($collection);
    }
}