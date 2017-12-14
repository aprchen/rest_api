<?php

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/10
 * Time: 下午6:12
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Transformers\Base;


use App\Component\Auth\Manager;
use App\Component\Auth\TokenParsers\TokenParserInterface;
use App\Component\Core\App;
use App\Component\Http\ErrorHelper;
use App\Component\Http\FormatHelper;
use App\Component\Http\Request;
use App\Component\Http\Response;
use App\Fractal\Query\Query;
use App\User\Service;
use League\Fractal\TransformerAbstract;
use Phalcon\Di;
use Phalcon\Exception;

/**
 * @author Olivier Andriessen olivierandriessen@gmail.com Bart Blok bart@wittig.nl
 * @source(redound/phalcon-api)
 */
/**
 * @property App $application
 * @property Request $request
 * @property Response $response
 * @property Manager $authManager
 * @property  Service $userService
 * @property ErrorHelper $errorHelper
 * @property FormatHelper $formatHelper
 * @property TokenParserInterface $tokenParser
 * @property Query $query
 *
 * @property \Phalcon\Mvc\Dispatcher|\Phalcon\Mvc\DispatcherInterface $dispatcher;
 * @property \Phalcon\Mvc\Router|\Phalcon\Mvc\RouterInterface $router
 * @property \Phalcon\Mvc\Url|\Phalcon\Mvc\UrlInterface $url
 * @property \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface $cookies
 * @property \Phalcon\Filter|\Phalcon\FilterInterface $filter
 * @property \Phalcon\Flash\Direct $flash
 * @property \Phalcon\Flash\Session $flashSession
 * @property \Phalcon\Session\Adapter\Files|\Phalcon\Session\Adapter|\Phalcon\Session\AdapterInterface $session
 * @property \Phalcon\Events\Manager $eventsManager
 * @property \Phalcon\Db\AdapterInterface $db
 * @property \Phalcon\Security $security
 * @property \Phalcon\Crypt $crypt
 * @property \Phalcon\Tag $tag
 * @property \Phalcon\Escaper|\Phalcon\EscaperInterface $escaper
 * @property \Phalcon\Annotations\Adapter\Memory|\Phalcon\Annotations\Adapter $annotations
 * @property \Phalcon\Mvc\Model\Manager|\Phalcon\Mvc\Model\ManagerInterface $modelsManager
 * @property \Phalcon\Cache\BackendInterface $modelsCache
 * @property \Phalcon\Mvc\Model\MetaData\Memory|\Phalcon\Mvc\Model\MetadataInterface $modelsMetadata
 * @property \Phalcon\Mvc\Model\Transaction\Manager $transactionManager
 * @property \Phalcon\Assets\Manager $assets
 * @property \Phalcon\DI|\Phalcon\DiInterface $di
 * @property \Phalcon\Session\Bag $persistent
 * @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view
 */
class TransformerBase extends TransformerAbstract
{
    /**
     * Dependency Injector
     *
     * @var \Phalcon\DiInterface
     */
    protected $_dependencyInjector;

    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function getDI()
    {
        $dependencyInjector = $this->_dependencyInjector;

        if (!$dependencyInjector) {
            $dependencyInjector = Di::getDefault();
        }

        return $dependencyInjector;
    }

    public function __get($propertyName)
    {
        $dependencyInjector = null;
        $service = null;
        $persistent = null;

        $dependencyInjector = $this->_dependencyInjector;

        if (!$dependencyInjector) {
            $dependencyInjector = Di::getDefault();
        }

        if (!$dependencyInjector) {
            throw new Exception("A dependency injection object is required to access the application services");
        }

        /**
         * Fallback to the PHP userland if the cache is not available
         */
        if ($dependencyInjector->has($propertyName)) {

            $service = $dependencyInjector->getShared($propertyName);
            $this->{$propertyName} = $service;

            return $service;
        }

        if ($propertyName == "di") {

            $this->{"di"} = $dependencyInjector;
            return $dependencyInjector;
        }

        /**
         * A notice is shown if the property is not defined and isn't a valid service
         */
        trigger_error("Access to undefined property " . $propertyName);
        return null;
    }


    /* Format helper shortcuts */

    public function int($value)
    {
        return $this->formatHelper->int($value);
    }

    public function float($value)
    {
        return $this->formatHelper->float($value);
    }

    public function double($value)
    {
        return $this->formatHelper->float($value);
    }

    public function bool($value)
    {
        return $this->formatHelper->bool($value);
    }

    public function date($value)
    {
        return $this->formatHelper->date($value);
    }
}
