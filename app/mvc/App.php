<?php
namespace App\Mvc;
use Phalcon\Factory;
use Phalcon\Mvc\Micro;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:42
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class App extends Micro
{

    protected function getEndPoint(){

    }

    public function int(EndPoint $endPoint){
        $reader = new MemoryAdapter();
        $options = [
            'prefix'   => 'annotations',
            'lifetime' => '3600',
            'adapter'  => 'memory',      // Load the Memory adapter
        ];
        $annotations = Factory::load($options);
        $reflector = $reader->get($endPoint);

    }


}