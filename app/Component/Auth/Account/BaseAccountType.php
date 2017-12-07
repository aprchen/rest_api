<?php
/**
 * Created by PhpStorm.
 * User: yn
 * Date: 2017/8/22
 * Time: 15:05
 */

namespace App\Auth;

use App\Constants\CacheConstants;
use App\Model\User;
use App\Mvc\Cache;
use App\Mvc\TextMessage;
use App\Mvc\YnAccountType;
use App\Mvc\ApiException;
use PhalconApi\Constants\ErrorCodes;

class BaseAccountType implements YnAccountType
{

    //登录失败计数
    protected function numOfLogin(User $user){
        $res =(int)Cache::read(CacheConstants::LOGIN_FAILURES,$user->id) ?? 0;
        $res +=1;
        if($res>5){
            //TODO 添加计数,超过5次,账户isValidated=0;添加email提醒
            if($user->isValidated !==0){
                $user->isValidated =0;
                if($user->update()){
                    $msg = '尊敬的用户您好,您的账户因多次登录失败,已被安全锁定,详情咨询0571-88387680';
                    $sms = new TextMessage();
                    $sms->sendMessage($user->phone,$msg);
                }
                Cache::remove(CacheConstants::LOGIN_FAILURES,$user->id);
            }
            return;
        }
        Cache::write(CacheConstants::LOGIN_FAILURES,$user->id,$res,60*30);
    }

    /**
     * @param $user User
     * @throws ApiException
     */
    protected function statusOfUser($user){
        if (!$user) {
            throw new ApiException(ErrorCodes::AUTH_LOGIN_FAILED,'Not_found');
        }
        if($user->isValidated !== User::ACTIVE){
            throw new ApiException(ErrorCodes::AUTH_LOGIN_FAILED,'Not_certified');
        }
        if($user->status !== User::STATUS_ON){ //禁用
            throw new ApiException(ErrorCodes::AUTH_LOGIN_FAILED,'Account_disabled');
        }
    }



    public function login($data)
    {
        throw new ApiException(ErrorCodes::POST_DATA_INVALID);
    }
    public function register($data)
    {
        throw new ApiException(ErrorCodes::POST_DATA_INVALID);
    }

    public function authenticate($identity)
    {
        throw new ApiException(ErrorCodes::POST_DATA_INVALID);
    }
}