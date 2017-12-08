<?php
/**
 * Created by PhpStorm.
 * User: yn
 * Date: 2017/8/22
 * Time: 15:05
 */

namespace App\Auth;

namespace App\Component\Auth\Account;

use App\Component\ApiException;
use App\Constants\ErrorCode;
use App\Models\User;

class BaseAccountType implements AccountType
{

    protected function numOfLogin(User $user){
    }

    /**
     * @param $user User
     * @throws ApiException
     */
    protected function statusOfUser($user){
        if (!$user) {
            throw new ApiException(ErrorCode::AUTH_LOGIN_FAILED,'Not_found');
        }
        if($user->isActive !== User::ACTIVE){ //禁用
            throw new ApiException(ErrorCode::AUTH_LOGIN_FAILED,'Account_disabled');
        }
    }

    public function login($data)
    {
        throw new ApiException(ErrorCode::POST_DATA_INVALID);
    }
    public function register($data)
    {
        throw new ApiException(ErrorCode::POST_DATA_INVALID);
    }

    public function authenticate($identity)
    {
        throw new ApiException(ErrorCode::POST_DATA_INVALID);
    }
}