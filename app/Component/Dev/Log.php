<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/3
 * Time: 下午8:57
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Dev;


use Phalcon\Logger\Adapter\File;

class Log
{
    private static $_logger;

    public static function logger($file = 'log.log')
    {
        $logDir = APP_PATH . '/Logs/';
        $dateDir = date("Ymd") . '/';
        self::makeDir($logDir);
        self::makeDir($logDir . $dateDir);
        if (empty(self::$_logger)) {
            self::$_logger = new File($logDir . $dateDir . $file);
        }
        return self::$_logger;
    }

    private static function makeDir($dir)
    {
        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                exit("Can`t make dir from $dir \n");
            };
        }
    }

}