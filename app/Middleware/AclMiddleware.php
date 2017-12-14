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
 */
class AclMiddleware  extends ApiPlugin implements MiddlewareInterface
{

    public function beforeExecuteRoute(Event $event, App $app)
    {
        $allowed = false;
        $data =$app->getMatchedEndpoint();
        $pointScopes = $data[PointMap::SCOPES] ?? [];
        if(empty($pointScopes)){ //如果point 没有配置scopes 则默认公开访问
            return true;
        }
        $scopes = $this->userService->getScopes(); //获取用户角色的scopes,看是否和point的scopes匹配
        if (!empty($pointScopes) && isset($scopes)) {
            foreach ($scopes as $scope){
                $allowed = in_array($scope,$pointScopes);
                if($allowed){
                    break;
                }
            }
        }
        if (!$allowed) {
            throw new ApiException(ErrorCode::ACCESS_DENIED);
        }
        return true;
    }

    public function call(Micro $application)
    {
        return true;
    }


}