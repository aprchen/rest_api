<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/7
 * Time: 下午2:03
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
/**
 * @author(redound/phalcon-rest-boilerplate)
 * @see("http://phalcon-rest.redound.org)
 */
namespace App\Component\Auth;


interface AccountType
{
    /**
     * @param array $data Login data
     *
     * @return string Identity
     */
    public function login($data);

    /**
     * @param string $identity Identity
     *
     * @return bool Authentication successful
     */
    public function authenticate($identity);


    /**
     * @param array $data Login data
     *
     * @return string Identity
     */
    public function register($data);

}