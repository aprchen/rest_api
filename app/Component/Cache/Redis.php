<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/7
 * Time: 下午1:28
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
namespace App\Component\Cache;

use App\Component\ApiException;
use App\Component\Core\ApiPlugin;
use App\Constants\ErrorCode;
use App\Constants\Services;

class Redis extends ApiPlugin
{
    /** @var  \Redis */
    private $con;
    protected static $instance;
    protected $tryConnectTimes = 0;
    protected $maxTryConnectTimes = 3;

    private function __construct()
    {
        $this->connect();
    }

    protected function connect()
    {
        $this->tryConnectTimes++;
        $conf = $this->getDI()->getShared(Services::CONFIG)->get(Services::REDIS_CACHE);
        $this->con = new \Redis();
        $this->con->connect($conf['host'], $conf['port'], 2);
        $this->con->auth($conf['auth']);
        if (!$this->ping()) {
            if ($this->tryConnectTimes <= $this->maxTryConnectTimes) {
                return $this->connect();
            } else {
               throw new ApiException(ErrorCode::POST_DATA_INVALID,"redis connect fail");
            }
        }
        $this->con->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
    }

    public static function getInstance()
    {
        if (is_object(self::$instance)) {
            return self::$instance;
        } else {
            self::$instance = new Redis();
            return self::$instance;
        }
    }

    public function rPush($key, $val)
    {
        try {
            return $this->con->rpush($key, $val);
//            return $ret;
        } catch (\Exception $e) {
            $this->connect();
            if ($this->tryConnectTimes <= $this->maxTryConnectTimes) {
                return $this->rPush($key, $val);
            } else {
                return false;
            }

        }

    }

    public function lPop($key)
    {
        try {
            return $this->con->lPop($key);
        } catch (\Exception $e) {
            $this->connect();
            if ($this->tryConnectTimes <= $this->maxTryConnectTimes) {
                return $this->lPop($key);
            } else {
                return false;
            }

        }
    }

    public function lSize($key)
    {
        try {
            $ret = $this->con->lSize($key);
            return $ret;
        } catch (\Exception $e) {
            $this->connect();
            if ($this->tryConnectTimes <= $this->maxTryConnectTimes) {
                return $this->lSize($key);
            } else {
                return false;
            }

        }
    }

    public function getRedisConnect()
    {
        return $this->con;
    }

    private function ping()
    {
        try {
            $ret = $this->con->ping();
            if (!empty($ret)) {
                $this->tryConnectTimes = 0;
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

}