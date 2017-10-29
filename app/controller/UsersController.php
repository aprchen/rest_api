<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;


class UsersController extends ControllerBase
{
    public function get($id){
        echo "<h1>ID is {$id}</h1>";
    }

}