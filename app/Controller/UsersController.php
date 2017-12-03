<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;


use App\Constants\ErrorCode;


/**
 * Class UsersController
 * @package App\Controller
 * @group(path="/user")
 */
class UsersController extends ControllerBase
{
    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @point(path="/",method="get")
     */
    public function index(){
        $res =["hello world"];
        return $this->response->setJsonContent($res);
    }

    /**
     * @point(path="/me")
     */
    public function me(){
        echo 11;
    }

}