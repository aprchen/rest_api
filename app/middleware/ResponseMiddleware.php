<?php
namespace App\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:22
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
class ResponseMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Micro $application
     *
     * @returns bool
     *
     * TODO 异常捕获
     */
    public function call(Micro $application)
    {
        $value = $application->getReturnedValue();
        if (is_object($value)) {
            $value = $value->toArray();
            $payload = $this->format($value);
        } elseif (is_bool($value)) {
            if($value ===false){
                $payload = $this->format('', "Can`t find data", '','error');
            }else{
                $payload = $this->format('', "操作成功");
            }
        } else {
            return false;
        }
        $application->response->setJsonContent($payload);
        $application->response->send();
        return true;
    }

    protected function format($data = null, $message = null, $code = 0, $status = "success")
    {
        return $payload = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'payload' => $data,
        ];
    }

}