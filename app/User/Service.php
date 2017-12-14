<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/8
 * Time: 下午3:43
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
namespace App\User;

use App\Component\ApiException;
use App\Component\Core\ApiPlugin;
use App\Constants\Acl\UserRoles;
use App\Constants\ErrorCode;
use App\Models\User;

/**
 * Class Service
 * @package App\User
 * @author redound/phalcon-rest-boilerplate
 */
class Service extends ApiPlugin
{
    protected $detailsCache = [];

    public function getDetails()
    {
        $details = null;

        $session = $this->authManager->getSession();
        if ($session) {
            $identity = $session->getIdentity();
            $details = $this->getDetailsForIdentity($identity);
        }
        return $details;
    }


    protected function getDetailsForIdentity($identity)
    {
        if (array_key_exists($identity, $this->detailsCache)) {
            return $this->detailsCache[$identity];
        }

        $details = User::findFirst((int)$identity);
        $this->detailsCache[$identity] = $details;

        return $details;
    }

    public function getIdentity()
    {
        $session = $this->authManager->getSession();
        if ($session) {
            return $session->getIdentity();
        }
        return null;
    }


    public function getRole()
    {
        /** @var User $userModel */
        $userModel = $this->getDetails();
        $role = [];
        if($userModel && isset($userModel->userRole)){
            $arr = [];
            foreach ($userModel->userRole as $item){
                if($item->role){
                    $arr[] =$item->role->name;
                }else{
                    throw new ApiException(ErrorCode::POST_DATA_INVALID,'role data error');
                }
            }
            $role = array_merge($role,$arr);
        }
        return $role;
    }

    public function getScopes(){
        /** @var User $userModel */
        $userModel = $this->getDetails();
        $scopes = [];
        if($userModel && isset($userModel->userRole)){
            $arr = [];
            foreach ($userModel->userRole as $item){
                if($item->role && $item->role->scope){
                    $arr[] =$item->role->scope->name;
                }else{
                    throw new ApiException(ErrorCode::POST_DATA_INVALID,'scope data error');
                }
            }
            $scopes = array_merge($scopes,$arr);
        }
        return $scopes;
    }

    public function isVip(){
        return isset($this->getRole()[UserRoles::VIP]) ?? false;
    }

    public function isAdministrator(){
        return isset($this->getRole()[UserRoles::ADMINISTRATOR]) ?? false;
    }

    public function isManager(){
        return isset($this->getRole()[UserRoles::MANAGER]) ?? false;
    }

}