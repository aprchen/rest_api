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
 * 用户端点
 * @url_prefix(value = "/users")
 */
class UsersController extends ControllerBase
{
    /**
     * @internal
     * @api {get} /:id
     * @apiPermission commonUsers
     * @Mapping(path = "/{id}",method ="get")
     * @ScopesCommonUsers "需要用户登录"
     */
    public function get($id){
        $res =["hello"];
        return $this->response->setJsonContent($res);
    }

    /**
     * @Mapping(path = "/me")
     * @ScopesPublic 公开
     * @Firewall 用于限制Ip
     */
    public function me(){
        echo 11;
    }

}