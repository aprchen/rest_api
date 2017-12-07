<?php

namespace App\Auth;

use App\Constants\Services;
use App\Mvc\YnAccountType;
use Phalcon\Di;

class EmailAccountType implements YnAccountType
{
    const NAME = "email";

    public function login($data)
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Services::SECURITY);

        $email = $data[Manager::LOGIN_DATA_USERNAME];
        $password = $data[Manager::LOGIN_DATA_PASSWORD];

        /** @var \App\Model\User $user */
        $user = \App\Model\User::findFirst([
            'conditions' => 'email = :email:',
            'bind' => ['email' => $email]
        ]);

        if (!$user) {
            return null;
        }

        if (!$security->checkHash($password, $user->password)) {
            return null;
        }

        return (string)$user->id;
    }

    public function register($data)
    {
        // TODO: Implement register() method.
    }

    public function authenticate($identity)
    {
        return \App\Model\User::count([
            'conditions' => 'id = :id:',
            'bind' => ['id' => (int)$identity]
        ]) > 0;
    }
}