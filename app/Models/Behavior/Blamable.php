<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/13
 * Time: 下午1:37
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Models\Behavior;


use App\Component\Dev\Log;
use App\Constants\Services;
use App\User\Service;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;
use Phalcon\Mvc\ModelInterface;

class Blamable extends Behavior implements BehaviorInterface
{
    public function notify($eventType, ModelInterface $model)
    {
        switch ($eventType) {
            case 'afterCreate':
            case 'afterDelete':
            case 'afterUpdate':
                $log = Log::logger('blamable.log');
                /** @var Service $userService */
                $userService = $this->getDI()->get(Services::USER_SERVICE);
                $userName = $userService->getDetails()->name;
                $log->info($userName . ' ' . $eventType . ' ' . $model->id);
                break;
            default:
                /* ignore the rest of events */
        }
    }
}