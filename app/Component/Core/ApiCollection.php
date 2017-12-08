<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/1
 * Time: 下午10:27
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Core;
use App\Component\ApiException;
use App\Constants\Core\PointMap;
use App\Constants\ErrorCode;
use App\Constants\Http\Methods;
use Phalcon\Mvc\Micro\Collection;
use Phalcon\Mvc\Micro\CollectionInterface;

class ApiCollection extends Collection implements CollectionInterface
{
    protected $points;
    protected $name;
    protected $controllerName;
    protected $metadata;
    protected $prefix;

    public function __construct(string $className,$lazy = false)
    {
        $core = Core::getInstance()->setHandle($className);
        $class = $className;
        if(!$lazy){ //非懒加载,实例化handle
            $class = $core->getHandleInstance();
        }
        $this->setHandler($class);
        $this->metadata = $core->getClassValue(PointMap::DEFAULT_GROUP_NAME);//controller group 注释的反射
        $this->controllerName = $className;
        $this->setName();
        $this->setGroupPrefix();
        $docMethod = $core->getMethodValue(PointMap::DEFAULT_POINT_NAME);//controller method 的 point 反射
        $this->setPrefix($this->prefix);
        $this->mountPoint($docMethod);
    }

    protected function setName()
    {
//        if(!isset($this->metadata[PointMap::NAME])){
//            throw new ApiException(ErrorCode::POST_DATA_INVALID,$this->getControllerName().' group name invalid');
//        }
        $this->name = $this->metadata[PointMap::NAME];
    }


    protected function setGroupPrefix()
    {
        $this->prefix = $this->metadata[PointMap::PATH] ?? PointMap::DEFAULT_PATH;
    }

    public function getName(){
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPoint(){
        return $this->points;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }
    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @param mixed $controllerName
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    protected function mountPoint(array $points)
    {
        if ($points && count($points) > 0) {
            foreach ($points as $handle => $item) {
                $point = new Point($item);
                $path = $point->getPath();
                $method = $point->getMethod();
                $handleName = serialize([
                    App::GROUP=>$this->getMetadata(),
                    App::POINT=>$item
                ]);
                if ($path && in_array(strtoupper($method),Methods::$ALL_METHODS)) {
                    if(is_array($path)){
                        foreach ($path as $value){
                            $this->$method($value,$handle,$handleName);
                        }
                    }else{
                        $this->$method($path,$handle,$handleName);
                    }
                }else{
                    throw new ApiException(ErrorCode::POST_DATA_INVALID,"path error or method invalid");
                }
            }
        }
    }
}