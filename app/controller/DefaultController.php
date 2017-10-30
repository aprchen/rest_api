<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;

class DefaultController extends ControllerBase
{
    /**
     * @Mapping(path = "/error")
     */
    public function error404(){
        echo $this->view->render("404");
    }

    /**
     * @Mapping(path = "/",method ="get")
     * @ScopesPublic 公开
     */
    public function index(){
        echo $this->view->render("index");
    }



}