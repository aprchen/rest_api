<?php
namespace App\Constants\Core;
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/1
 * Time: 下午11:15
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

class PointMap
{

    const DEFAULT_GROUP_NAME = 'group';
    const DEFAULT_POINT_NAME = 'point';
    const DEFAULT_METHOD = 'get';
    const DEFAULT_PATH = '/';
    const DEFAULT_NAME = null;
    const DEFAULT_ALLOW = [];
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
     * @group 必填
     * @point 必填
     */
    const NAME = "name";
    /**
     * @point;
     * 权限,作用域
     */
    const SCOPES = "scopes";

}