<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午9:01
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Controller;

/**
 * Class DefaultController
 * @package App\Controller
 * @group(path="/",name='default')
 */
class DefaultController extends ControllerBase
{

    /**
     * @point(path="error404",name=404)
     */
    public function error404()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->response->sendHeaders();
        $this->response->send();
        echo $this->view->render("404");
    }

    /**
     * @point(path="error500",name=500)
     */
    public function error500()
    {
        $this->response->setStatusCode(500, 'Server Error');
        $this->response->sendHeaders();
        $this->response->send();
        echo $this->view->render("500");
    }

    /**
     * @point(path='/',name='index')
     */
    public function index()
    {
        echo $this->view->render('index');
    }
}