<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller\WeChat;

use App\Component\EndPointManager;
use App\Controller\ControllerBase;


/**
 * Class IndexController
 * @package App\Controller\WeChat
 * @group(path="/wechat",fire_wall="list")
 */
class IndexController extends ControllerBase
{
    /**
     * @point(path={"/","/index"},method="get",name="wechat")
     */
    public function index(){
        echo 1;
    }
}