<?php
namespace App\Component\Core;

use Phalcon\Mvc\Micro;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:42
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class App extends Micro
{
    const GROUP = 'g';
    const POINT = 'p';
    protected $matchedRouteNameParts = null;

    /**
     * @return mixed|null 返回当前路由的group 参数
     *
     */
    public function getMatchedCollection()
    {
        $group = $this->getMatchedRouteNamePart(self::GROUP);
        if (!$group) {
            return null;
        }
        return $group;
    }

    /**
     * @return mixed|null 返回当前路由的 point 参数
     */
    public function getMatchedEndpoint()
    {
        $endpoint = $this->getMatchedRouteNamePart(self::POINT);
        return $endpoint;
    }

    protected function getMatchedRouteNamePart($key)
    {
        if (is_null($this->matchedRouteNameParts)) {
            $routeName = $this->getRouter()->getMatchedRoute()->getName();
            if (!$routeName) {
                return null;
            }
            $this->matchedRouteNameParts = @unserialize($routeName);
        }
        if (is_array($this->matchedRouteNameParts) && array_key_exists($key, $this->matchedRouteNameParts)) {
            return $this->matchedRouteNameParts[$key];
        }

        return null;
    }
}