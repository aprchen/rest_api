<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/2
 * Time: 下午6:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component;

use Phalcon\Annotations\Annotation;
use Phalcon\Annotations\Collection;
use Phalcon\Annotations\Reflection;
use Phalcon\Annotations\Factory;

class Core
{

    const TYPE_CLASS = "class";
    const TYPE_METHOD = "method";
    const TYPE_PROPERTY = "property";
    /**
     * 'prefix'   => 'annotations',
     * 'lifetime' => '3600',
     * 'adapter'  => 'memory',      // Load the Memory adapter,type{memory,apc,files and Xcache}
     * 开发测试时,使用memory,正式环境,建议使用,apc高速缓存
     */
    private static $config;

    /**
     * @var $instance Core;
     */
    protected static $instance;

    private $annotations;
    private $handle;
    /**
     * @var $reflection Reflection
     */
    private $reflection;

    static function getInstance($config = [])
    {
        if (!isset(self::$instance)) {
            self::$instance = new static($config);
        }
        return self::$instance;
    }

    public function init()
    {
        $this->reflection = $this->annotations->get($this->handle);
        return $this;
    }

    private function __construct($config)
    {
        if (empty(self::$config)) {
            self::$config = $config;
        }
        $this->annotations = Factory::load(self::$config);
    }

    public function getValue($name, $type = self::TYPE_CLASS)
    {
        $res = false;
        if($type == self::TYPE_CLASS){
            $res = $this->getClassValue($name);
        }
        if($type == self::TYPE_METHOD){
            $res = $this->getMethodValue($name);
        }
        return $res;
    }

    public function getClassValue($name){
        $collection = $this->reflection->getClassAnnotations();
        if(!$collection){
            return false;
        }
        $result = $this->getAnnotations($collection,$name);
        if($result instanceof Annotation){
            return $result->getArguments();
        }
        return $result;
    }

    public function getMethodValue($name){
        $array = $this->reflection->getMethodsAnnotations();
        $result =[];
        if ($array && count($array) > 0) {
            foreach ($array as $funName =>$collection) {
                $res = $this->getAnnotations($collection,$name);
                if($res && $res instanceof Annotation){
                    $result[$funName] = $res->getArguments();
                }
            }
        }
        return $result;
    }

    protected function getAnnotations(Collection $collection,$name){
        $result = false;
        if($collection->has($name)){
            $result = $collection->get($name);
        }
        if (count($collection) > 0) {
            foreach ($collection as $item) {
                if ($item->hasArgument($name)) {
                    $result = $item->getArgument($name);
                    break;
                }
            }
        }
        return $result;
    }

    public function setHandle($source)
    {
        $this->handle = $source;
        return $this;
    }
}