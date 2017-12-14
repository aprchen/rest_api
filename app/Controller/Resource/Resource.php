<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/9
 * Time: 下午6:15
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
namespace App\Controller\Resource;

use App\Constants\Acl\Scopes;
use App\Controller\ControllerBase;
use League\Fractal\Resource\Collection;

/**
 * Class Resource
 * @package App\Controller\Resource
 * @group(path='/resources',name='resources')
 */
class Resource extends ControllerBase
{
    /**
     * @point(method='get',path="/")
     */
    public function get(){
        $res = [
            [
                'name'=>'users',
                'scopes'=>[Scopes::SCOPES_COMMON_USERS,Scopes::SCOPES_MANAGER_USERS,Scopes::SCOPES_SUPER_USERS],
                'link'=>[
                    'rel'=>'resources',
                    'uri'=>'/users'
                ],
            ]
        ];
        $resource = new Collection($res,function ($res){
            return [
                [
                    'name'=>$res['name'],
                    'scopes'=>$res['scopes'],
                    'link'=>$res['link']
                ],
                'links'=>[
                    'rel'=>'self',
                    'uri'=>'/search'
                ]
            ];
        });
        $response = $this->fractal->createData($resource)->toArray();
        return $this->createResponse($response);
    }

    public function post(){

    }

    public function put(){

    }

    public function delete(){

    }
}