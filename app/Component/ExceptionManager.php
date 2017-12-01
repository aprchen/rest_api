<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/1
 * Time: 下午6:52
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component;


use App\Constants\ErrorCode;
use Phalcon\Mvc\Micro;
use Throwable;

class ExceptionManager
{
    /**
     * @param Throwable $t
     * @param Micro $app
     * @return bool
     */
    public function handle(Throwable $t, Micro $app)
    {


    }
}