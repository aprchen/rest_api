<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller\WeChat;


use App\Constants\ErrorCode;
use App\Controller\ControllerBase;


/**
 * Class UsersController
 * @package App\Controller
 * 用户端点
 * @url_prefix(value = "/wechat")
 */
class IndexController extends ControllerBase
{
    /**
     * @internal
     * @apiPermission commonUsers
     * @Mapping(path = "/index",method ="get")
     * @ScopesCommonUsers "需要用户登录"
     */
    public function index(){
        $res =["hello"];
        return $this->response->setJsonContent($res);
    }
}