<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/11/7
 * Time: 下午1:24
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component;


class ApiException extends \Exception
{
    protected $developerInfo;
    protected $userInfo;

    public function __construct($code, $message = null, $developerInfo = null, $userInfo = null)
    {
        parent::__construct($message, $code);

        $this->developerInfo = $developerInfo;
        $this->userInfo = $userInfo;
    }

    public function getDeveloperInfo()
    {
        return $this->developerInfo;
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }
}