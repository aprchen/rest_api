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
use App\Constants\Services;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use Phalcon\Annotations\Factory;
use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

class UsersController extends ControllerBase
{
    /**
     * @GetMapping(path = "/users/get/{id}")
     */
    public function get($id){
        $res =["hello"];
        return $this->response->setJsonContent($res);
    }

    /**
     * @GetMapping(path = {"/error"})
     */
    public function error(){
        throw new \Exception(ErrorCode::DATA_NOT_FOUND);
    }

}