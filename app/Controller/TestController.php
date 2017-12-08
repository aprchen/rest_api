<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;

/**
 * Class TestController
 * @package App\Controller
 * @group(path="/test",name='test')
 */
class TestController extends ControllerBase
{
    /**
     * @point(path="/test/{id}",name='one',scopes={unauthorized})
     * @param $id
     */
    public function one($id)
    {
        echo $id;
    }
    /**
     * @point(path="/{s}",name='two',scopes={unauthorized})
     */
    public function two($s)
    {
      echo "test:${s}";
    }

}