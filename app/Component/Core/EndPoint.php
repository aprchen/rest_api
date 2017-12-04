<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/1
 * Time: 下午10:27
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Core;
class EndPoint
{
    const GROUP = "group";
    const POINT = "point";

    protected $points;
    protected $group;
    protected $handle;

    public function initialize()
    {
        $core = Core::getInstance()->setHandle($this->getHandle())->init();
        $this->group = $core->getValue(self::GROUP,Core::TYPE_CLASS);
        $this->points = $core->getValue(self::POINT,Core::TYPE_METHOD);
        return $this;
    }

    public function getHandleInstance(){
        $oReflectionClass = new \ReflectionClass($this->getHandle());
        $instance = $oReflectionClass->newInstance();
        return $instance;
    }

    public function getHandle()
    {
        return $this->handle;
    }

    public function setHandle(string $controller)
    {
        $this->handle = $controller;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }
}