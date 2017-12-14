<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/12
 * Time: 下午1:45
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Models;


use App\Models\Base\ModelBase;

class Wechat extends ModelBase
{
    public $name;
    public $userId;
    public $appId;
    public $token;
    public $appSecret;
    public $aesKey;
    public $type;
    public $isActive;

    public function columnMap()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'user_id' => 'userId',
            'app_id' => 'appId',
            'token' => 'token',
            'app_secret' => 'appSecret',
            'aes_key' => 'aesKey',
            'is_active' => 'isActive',
            'type' => 'type',
            'gmt_create' => 'gmtCreate',
            'gmt_modified' => 'gmtModified'
        );
    }

    public function initialize()
    {

    }

}