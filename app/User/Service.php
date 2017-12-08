<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/8
 * Time: 下午3:43
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
namespace App\User;

use App\Component\Core\ApiPlugin;
use App\Constants\Acl\Scopes;
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
        $role = [Scopes::SCOPES_UNAUTHORIZED];
        if($userModel && isset($userModel->userRole)){
            $arr = [];
            $userRoles =  $userModel->userRole;
            if(count($userRoles)>0){
                $arr = array_column($userRoles,'role','areasId');
            }
            $role = array_merge($role,$arr);
        }

        return $role;
    }
}