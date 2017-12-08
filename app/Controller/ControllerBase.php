<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;
use App\Component\Auth\Manager;
use App\Component\Auth\TokenParsers\JWTTokenParser;
use App\Component\Http\Request;
use App\Component\Http\Response;
use App\User\Service;
use Phalcon\Config;
use Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 * @package App\Component\Core
 * @property Request $request
 * @property Response $response
 * @property JWTTokenParser $tokenParser
 * @property Manager $authManager
 * @property Config $config
 * @property Service $userService
 */
class ControllerBase extends Controller
{

    public function responseOk(){
        $data = [
            'status'  => 'ok'
        ];
       return $this->response->setJsonContent($data);
    }

    public function responseItem(array $data){
        return $this->response->setJsonContent($data);
    }
}