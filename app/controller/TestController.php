<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;


use App\Mvc\EndPoint;

class TestController extends ControllerBase
{
    /**
     * @GetMapping(path = {"/"})
     */
    public function test(){
        require 'views/index';
    }
}