<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/4
 * Time: 下午12:20
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
namespace App\Component\Http;

use App\Component\ApiException;
use App\Component\Dev\Log;
use App\Constants\Services;

class Response extends \Phalcon\Http\Response
{
    public function setErrorContent(\Throwable $t, $developerInfo = false)
    {
        /** @var Request $request */
        $request = $this->getDI()->get(Services::REQUEST);
        /** @var  $errorHelper ErrorHelper */
        $errorHelper = $this->getDI()->has(Services::ERROR_HELPER) ? $this->getDI()->get(Services::ERROR_HELPER) : null;

        $errorCode = $t->getCode();
        $statusCode = 500;
        $message = $t->getMessage();

        if ($errorHelper && $errorHelper->has($errorCode)) {
            $defaultMessage = $errorHelper->get($errorCode);
            $statusCode = $defaultMessage['statusCode'];
            if (!$message) {
                $message = $defaultMessage['message'];
            }
        }
        $error = [
            'code' => $errorCode,
            'message' => $message ?: 'Unspecified error',
        ];
        if ($t instanceof ApiException && $t->getUserInfo() != null) {
            $error['info'] = $t->getUserInfo();
        }
        if ($developerInfo === true) {
            $developerResponse = [
                'file' => $t->getFile(),
                'line' => $t->getLine(),
                'request' => $request->getMethod() . ' ' . $request->getURI()
            ];
            if ($t instanceof ApiException && $t->getDeveloperInfo() != null) {
                $developerResponse['info'] = $t->getDeveloperInfo();
            }
            $error['developer'] = $developerResponse;
        }
        if(!$developerInfo){
            $log = Log::logger();//日志记录
            if($t->getCode()> 5000){
                $log->error('msg:'.$message);
            }
        }
        $this->setJsonContent(['error' => $error]);
        $this->setStatusCode($statusCode);
    }

    public function setJsonContent($content, $jsonOptions = 0, $depth = 512)
    {
        parent::setJsonContent($content, $jsonOptions, $depth);
        $this->setContentType('application/json', 'UTF-8');
        $this->setEtag(md5($this->getContent()));
    }
}