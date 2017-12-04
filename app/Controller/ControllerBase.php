<?php
namespace App\Controller;
use App\Mvc\EndPoint;
use Phalcon\Mvc\Controller;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:41
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class ControllerBase extends Controller
{

    public function responseOk(){
        $data = [
            'code'    => 200,
            'status'  => 'success',
            'message' => 'ok',
            'payload' => [],
        ];
       return $this->JsonReturn($data);
    }

    public function JsonReturn(array $data){
        return $this->response->setJsonContent($data);
    }
}