<?php
namespace App\Models;
use Phalcon\Mvc\Model;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/28
 * Time: 下午7:14
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class User extends Model
{
    const ACTIVE = 1;
    const EMAIL_VERIFIED =1;

    public $isActive;

}