<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/7
 * Time: 下午2:14
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Auth;

interface TokenParserInterface
{
    /**
     * @param Session $session Session to generate token for
     *
     * @return string Generated token
     */
    public function getToken(Session $session);

    /**
     * @param string $token Access token
     *
     * @return Session Session restored from token
     */
    public function getSession($token);

    public function getSessionWithRedis($token);
}
