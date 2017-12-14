<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/7
 * Time: 下午3:21
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Middleware;


use App\Component\Core\ApiPlugin;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class AuthTokenMiddleware extends ApiPlugin implements MiddlewareInterface
{

    public function beforeExecuteRoute()
    {
        $token = $this->request->getToken();
        if ($token) {
            return $this->authManager->authenticateToken($token);
        }
        return false;
    }

    /**
     * Calls the middleware
     *
     * @param \Phalcon\Mvc\Micro $application
     */
    public function call(\Phalcon\Mvc\Micro $application)
    {
        // TODO: Implement call() method.
    }
}