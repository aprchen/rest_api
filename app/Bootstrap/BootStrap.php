<?php
namespace App\BootStrap;

use App\Component\BootstrapInterface;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午3:54
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 * @see {redound/phalcon-rest-boilerplate}
 *
 */
class BootStrap
{
    protected $_executables;

    public function __construct(BootstrapInterface ...$executables)
    {
        $this->_executables = $executables;
    }

    public function run(...$args)
    {
        foreach ($this->_executables as $executable) {
            call_user_func_array([$executable, 'run'], $args);
        }
    }
}
