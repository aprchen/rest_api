<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/4
 * Time: 下午4:11
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Component\Core;

use App\Component\Http\ErrorHelper;
use App\Component\Http\FormatHelper;
use App\Component\Http\Request;
use App\Component\Http\Response;
use App\Constants\Services;
use Phalcon\Di\FactoryDefault;

class ApiFactory extends FactoryDefault
{
    public function __construct()
    {
        parent::__construct();
        $this->setShared(Services::REQUEST, new Request);
        $this->setShared(Services::RESPONSE, new Response);
        $this->setShared(Services::FORMAT_HELPER, new FormatHelper);
        $this->setShared(Services::ERROR_HELPER, new ErrorHelper);
    }

}