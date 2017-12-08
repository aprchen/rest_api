<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;


/**
 * Class IndexController
 * @package App\Controller\WeChat
 * @group(path="/wechat",name='wechat')
 */
class WeChatController extends ControllerBase
{
    /**
     * @point(path={"/","/index"},method="get",name="index")
     */
    public function index(){
        echo 1;
    }
}