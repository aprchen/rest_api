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

/**
 * Class Service
 * @package App\User
 * @author redound/phalcon-rest-boilerplate
 */
class Service extends ApiPlugin
{

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
        $role = [Scopes::SCOPES_UNAUTHORIZED];
        return $role;
    }


}