<?php
namespace App\Mapper\APIDoc;
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/30
 * Time: 下午2:49
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
interface Method
{

    /**
     * @param String $path url,路径
     * @return mixed
     * @deprecated
     */
    function GetMapping(String $path);

}