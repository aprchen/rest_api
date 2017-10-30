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
 * Class RoomController
 * @package App\Controller
 * @url_prefix(value = "/rooms")
 */
class RoomController extends ControllerBase
{
    /**
     * @Mapping(path = "/",method ="get")
     * @ScopesPublic 公开
     */
    public function roomList(){
        echo "room list";
    }

    /**
     * @Mapping(path = "/{id}",method="get")
     */
    public function getId(){
        echo 11;
    }
}