<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/10
 * Time: 下午7:07
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller\Resource;

use App\Component\ApiException;
use App\Constants\ErrorCode;
use App\Controller\ControllerBase;
use App\Models\User;
use App\Transformers\UserTransformer;

/**
 * Class UsersResource
 * @package App\Controller\Resource
 * @group(path="/resources/users",name='users')
 */
class UsersResource extends ControllerBase
{
    /**
     * @point(method='get',path={'/'})
     */
    public function getAll()
    {
        $data = $this->getUriBuilder(User::class)->getQuery()->execute();
        return $this->createCollectionResponse($data, new UserTransformer());
    }

    /**
     * @point(method='get',path={'/{id}'})
     */
    public function get($id)
    {
        $data = User::findFirst(['id= ?0','bind'=>[$id]]);
        if(!$data){
            throw new ApiException(ErrorCode::DATA_NOT_FOUND);
        }
        return $this->createItemResponse($data, new UserTransformer());
    }

    /**
     * @point(method='get',path='/me',scopes={common_user,super_user,manager_user})
     */
    public function me()
    {
        $links = [
            'links' =>
                [
                    [
                        'rel' => 'self',
                        'uri' => '/me',
                        'method' => 'get',
                        'description' => 'About me'
                    ],
                    [
                        'rel' => 'self',
                        'uri' => '/',
                        'method' => 'get',
                        'description' => 'All user'
                    ],
                    [
                        'rel' => 'self',
                        'uri' => '/{id}',
                        'method' => 'get',
                        'description' => 'Find a user'
                    ],

                ]
        ];
        return $this->createItemOkResponse(
            $this->userService->getDetails(),
            new UserTransformer(),
            'data',
            $links
        );
    }

}