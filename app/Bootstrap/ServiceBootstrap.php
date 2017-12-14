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
use App\Component\Auth\Account\UsernameAccountType;
use App\Component\Auth\TokenParsers\JWTTokenParser;
use App\Component\BootstrapInterface;
use App\Component\Core\App;
use App\Constants\Services;
use App\Fractal\CustomSerializer;
use App\Fractal\Query\QueryParsers\UrlQueryParser;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Simple as View;
use App\Component\Auth\Manager as AuthManager;
use App\User\Service as UserService;
use League\Fractal\Manager as FractalManager;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Cache\Frontend\Data as FrontendData;


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
            $authManager->registerAccountType(UsernameAccountType::NAME, new UsernameAccountType());
            return $authManager;
        });

        /**
         * @description Phalcon - \Phalcon\Db\Adapter\Pdo\Mysql
         * 数据库
         */
        $di->set(Services::DB, function () use ($config, $di) {

            $config = $config->get('database')->toArray();
            $adapter = $config['adapter'];
            unset($config['adapter']);
            $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;
            /** @var  $connection  Mysql */
            $connection = new $class($config);

            $connection->setEventsManager($di->get(Services::EVENTS_MANAGER));

            return $connection;
        });
        /**
         * redis,model 可以通过继承cacheBase实现缓存
         */
        $di->set(Services::REDIS_CACHE, function () use ($config) {
            // Cache data for one day (default setting)
            $modelConfig = $config->get('modelsCache')->toArray();
            $frontCache = new FrontendData(
                [
                    'lifetime' => $modelConfig['lifetime']['frontendData'],
                ]
            );
            $redis_config = $config->get('redis')->toArray();
            $cache = new Redis($frontCache, $redis_config);
            return $cache;
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
         * 模板引擎
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

        /**
         * @description \League\Fractal\Manager
         * @see(https://fractal.thephpleague.com) 文档地址
         * Fractal为复杂的数据输出提供了一个演示和转换层，就像在RESTful API中找到的那样，并且在JSON中工作得非常好。
         * 把它看作你的JSON / YAML /等的视图层。在构建API时，人们通常只需从数据库中获取内容并将其传递给json_encode（）。
         * 这对于“微不足道”的API可能是可行的，但是如果它们被公众使用，或者被移动应用程序使用，则这将很快导致不一致的输出。
         */
        $di->setShared(Services::FRACTAL_MANAGER, function () {
            $fractal = new FractalManager;
            $fractal->setSerializer(new CustomSerializer);
            return $fractal;
        });
        /**
         * resource url 参数解析
         */
        $di->setShared(Services::URL_QUERY_PARSER, new UrlQueryParser);


        /**
         * @description Phalcon - \Phalcon\Mvc\Model\Manager
         */
        $di->setShared(Services::MODELS_MANAGER, function () use ($di) {

            $modelsManager = new ModelsManager;
            return $modelsManager->setEventsManager($di->get(Services::EVENTS_MANAGER));
        });
    }

}