<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/11/7
 * Time: 下午4:45
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component;

use swoole_client;

class SwooleClient
{
    protected $client;
    public function __construct()
    {
        $this->client =$client = new swoole_client(SWOOLE_SOCK_TCP);
        $client->connect('127.0.0.1', 9501) || exit("connect failed. Error: {$client->errCode}\n");

    }

    public function send($taskName,$message=''){
        $arr = [
            'name'=>$taskName,
            'message'=>$message
        ];
        $this->client->send(json_encode($arr));
    }


    public function get(){
        $response = $this->client->recv();
        return $response;
    }

    public function __destruct()
    {
        $this->client->close();
    }
}