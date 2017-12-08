<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/2
 * Time: 下午6:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Core;

use App\Component\ApiException;
use App\Constants\ErrorCode;
use Phalcon\Annotations\Annotation;
use Phalcon\Annotations\Collection;
use Phalcon\Annotations\Factory;

/**
 * Class Core
 * @package App\Component\Core
 *
 */
class Core extends ApiPlugin
{

    const TYPE_CLASS = "class";
    const TYPE_METHOD = "method";
    const TYPE_PROPERTY = "property";

    /**
     * @var $instance Core;
     */
    protected static $instance;

    private $annotations;

    private $handle;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $config = $this->config->get('router')['annotations'];
        if(!isset($config)){
            throw new ApiException(ErrorCode::POST_DATA_NOT_PROVIDED,'配置文件不存在');
        }
        $this->annotations = Factory::load($config);
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
        $collection = $this->annotations->get($this->handle)->getClassAnnotations();
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
        $array = $this->annotations->get($this->handle)->getMethodsAnnotations();
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

    public function getHandle(){
        return $this->handle;
    }

    public function getHandleInstance($className =''){
        if($className == ''){
            $className = $this->getHandle();
        }
        $oReflectionClass = new \ReflectionClass($className);
        $instance = $oReflectionClass->newInstance();
        return $instance;
    }
}