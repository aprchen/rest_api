<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/7
 * Time: 下午1:48
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Core;


use App\Component\Auth\Manager;
use App\Component\Auth\TokenParsers\JWTTokenParser;
use App\Component\Http\Request;
use App\Component\Http\Response;

use App\Fractal\Query\QueryParsers\PhqlQueryParser;
use App\Fractal\Query\QueryParsers\UrlQueryParser;
use App\User\Service;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Config;
use Phalcon\Mvc\User\Plugin;


/**
 * Class ApiPlugin
 *
 * @package App\Component\Core
 * @property Request $request
 * @property Response $response
 * @property JWTTokenParser $tokenParser
 * @property Manager $authManager
 * @property Config $config
 * @property Service $userService
 * @property phqlQueryParser $phqlQueryParser
 * @property urlQueryParser $urlQueryParser
 * @property Redis $redis
 *
 * di注册提示用
 */
class ApiPlugin extends Plugin
{

}