<?php
namespace App\Middleware;

use App\Component\ApiException;
use App\Component\Core\ApiPlugin;
use App\Component\Core\App;
use App\Constants\Core\PointMap;
use App\Constants\ErrorCode;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:22
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 *
 */

/**
 * Class AclMiddleware
 * @package App\Middleware
 *
 * 检查当前用户角色有无方法当前接口权限
 */
class AclMiddleware  extends ApiPlugin implements MiddlewareInterface
{

    public function beforeExecuteRoute(Event $event, App $app)
    {
        $allowed = false;
        $data =$app->getMatchedEndpoint();
        $scopes = $data[PointMap::SCOPES] ?? [];
        $roles = $this->userService->getRole();

        if (!empty($roles) && isset($scopes)) {
            foreach ($roles as $role){
                $allowed = in_array($role,$scopes);
                if($allowed){
                    break;
                }
            }
        }
        if (!$allowed) {
            throw new ApiException(ErrorCode::ACCESS_DENIED);
        }
    }

    public function call(Micro $application)
    {
        return true;
    }


}