<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;

use Phalcon\Mvc\View\Simple;

class DefaultController extends ControllerBase
{

    /**
     * @point(path="/error404")
     * @var $view Simple
     */
    public function error404()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->response->sendHeaders();
        $this->response->send();
        echo $this->view->render("404");
    }

    /**
     * @point(path="/error500")
     */
    public function error500()
    {
        $this->response->setStatusCode(500, 'Server Error');
        $this->response->sendHeaders();
        echo $this->view->render("500");
        $this->response->send();
    }

    /**
     * @point(path="/")
     */
    public function index()
    {
        echo $this->view->render("index");
    }
}