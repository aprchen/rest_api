<?php
use Phalcon\Cli\Task;
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午1:00
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
}