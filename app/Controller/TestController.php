<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;

use App\Component\EndPointManager;
use App\Models\Account;
use App\Mvc\SwooleClient;

/**
 * Class TestController
 * @package App\Controller
 * @group(path="/test")
 */
class TestController extends ControllerBase
{
    /**
     * @point(path="test/{id}",allow="me")
     * @param $id
     */
    public function one($id)
    {
        echo $id;
    }
    /**
     * @point(path="/test",allow="me")
     */
    public function two()
    {
      $manager = EndPointManager::getInstance();
      var_dump($manager->getEndPoints());
    }

}