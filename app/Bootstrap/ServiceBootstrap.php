<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\BootStrap;

use App\Component\Auth\Account\EmailAccountType;
use App\Component\Auth\TokenParsers\JWTTokenParser;
use App\Component\BootstrapInterface;
use App\Component\Core\App;
use App\Component\Http\ErrorHelper;
use App\Constants\Services;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Simple as View;
use App\Component\Auth\Manager as AuthManager;
use App\User\Service as UserService;

class ServiceBootstrap implements BootstrapInterface
{

    public function run(App $app, FactoryDefault $di, Config $config)
    {
        /**
         * @description Config - \Phalcon\Config
         */
        $di->setShared(Services::CONFIG, $config);
        /**
         * @description Phalcon - EventsManager
         */
        $di->setShared(Services::EVENTS_MANAGER, new Manager());

        $di->setShared(Services::ERROR_HELPER, new ErrorHelper());

        /**
         * @description Phalcon - TokenParsers
         */
        $di->setShared(Services::TOKEN_PARSER, function () use ($di, $config) {
            return new JWTTokenParser($config->get('authentication')->secret, JWTTokenParser::ALGORITHM_HS256);
        });

        /**
         * @description Phalcon - AuthManager
         * 注册相应的账户类型
         */
        $di->setShared(Services::AUTH_MANAGER, function () use ($di, $config) {
            $authManager = new AuthManager($config->get('authentication')->expirationTime);
            $authManager->registerAccountType(EmailAccountType::NAME, new EmailAccountType());
            return $authManager;
        });


        /**
         * @description Phalcon - \Phalcon\Db\Adapter\Pdo\Mysql
         */
        $di->set(Services::DB, function () use ($config, $di) {

            $config = $config->get('database')->toArray();
            $adapter = $config['adapter'];
            unset($config['adapter']);
            $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;
            /** @var  $connection  Mysql*/
            $connection = new $class($config);

            $connection->setEventsManager($di->get(Services::EVENTS_MANAGER));

            return $connection;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\Url
         */
        $di->set(Services::URL, function () use ($config) {

            $url = new UrlResolver;
            $url->setBaseUri($config->get('application')->baseUri);
            return $url;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\View\Simple
         */
        $di->set(Services::VIEW, function () use ($config) {
            $view = new View();
            $view->setViewsDir($config->get('application')->viewsDir);
            return $view;
        });

        /**
         * @description PhalconRest - \PhalconRest\User\Service
         * 用户服务注册
         */
        $di->setShared(Services::USER_SERVICE, new UserService);

    }

}