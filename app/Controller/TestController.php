<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;

use App\Component\ApiException;
use App\Constants\ErrorCode;
use App\Models\User;
use App\Transformers\UserTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class TestController
 * @package App\Controller
 * @group(path="/test",name='test')
 */
class TestController extends ControllerBase
{
    /**
     * @point(path="/test/{id}",name='one')
     * @param $id
     */
    public function one($id)
    {
        echo $id;
    }
    /**
     * @point(path="/{s}",name='two')
     */
    public function two($s)
    {
      echo "test:${s}";
    }

    /**
     * @point(path='/oauth',name='oauth')
     */
    public function oauth(){
        $res = $this->getUriBuilder(User::class,'id')->getQuery()->execute();
        if(!$res){
           throw new ApiException(ErrorCode::DATA_NOT_FOUND);
        }
        $resource = new Collection($res, new UserTransformer(), 'data');
        $data = $this->fractal->createData($resource)->toArray();
        return $this->responseItem($data);
    }
    /**
     * @point(path="/url",name='redirectUrl')
     */
    public function redirectUrl(){
//        $token = "asdqweqw1e23q1w3e2q";
//        $scope = Scopes::SCOPES_COMMON_USERS;
//        $this->response->setStatusCode(302);
//        $this->response->setHeader('Location','http://host-api:7888/test/oauth');
//        $this->response->send();
    }

}