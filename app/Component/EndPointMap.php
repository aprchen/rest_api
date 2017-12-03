<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/1
 * Time: 下午11:15
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component;


class EndPointMap
{
    /**
     * 使用方法
     * 可以随意自定参数,
     * @group(path="/",name="name",some={1,32,31,24})
     * 其他位置获取方式
     */
    /**
     * @group
     * @point
     * url路径
     */
    const PATH = "path";
    /**
     * @point
     * 请求方式
     */
    const METHOD = "method";
    /**
     * @group
     * @point
     * 非必填
     */
    const NAME = "name";
    /**
     * @group
     * @point
     */
    const FIRE_WALL = "fire_wall";
}