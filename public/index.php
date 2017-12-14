<?php

use App\Component\Core\ApiFactory;
use App\Component\Core\App;
use App\Component\Http\Response;
use App\Constants\Services;

error_reporting(E_ALL);
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('VENDOR_DIR', BASE_PATH . '/vendor');
define('CONFIG_DIR', APP_PATH . '/config');
define('LOG_DIR', APP_PATH . '/logs');
/** 扩展检查 */
if (!extension_loaded('phalcon')) {
    exit("Please install phalcon extension. See https://phalconphp.com/zh/ \n");
}
require_once VENDOR_DIR . '/autoload.php';

if (file_exists(CONFIG_DIR . "/env.local.php")) {
    define('APPLICATION_ENV', 'local');
} else {
    define('APPLICATION_ENV', 'pro');
}

try {
    /** @var \Phalcon\Config $config */
    $config = null;
    /**
     * 默认配置
     */
    $configPath = CONFIG_DIR . '/default.php';

    if (!is_readable($configPath)) {
        throw new Exception('Unable to read config from ' . $configPath);
    }
    $config = include_once $configPath;

    $config = new Phalcon\Config($config);

    $envConfigPath = CONFIG_DIR . '/env.' . APPLICATION_ENV . '.php';

    if (!is_readable($envConfigPath)) {
        throw new Exception('Unable to read config from ' . $envConfigPath);
    }

    $override = new Phalcon\Config(include_once $envConfigPath);

    $config = $config->merge($override);

    /**
     * 注册命名空间和目录
     */
    $loader = new \Phalcon\Loader();
    $loader->registerNamespaces([
        "App" => APP_PATH
    ]);
    $loader->registerDirs(
        [
            $config->get("application")->modelsDir,
        ]
    )->register();

    /**
     *默认DI 容器
     */

    $di = new ApiFactory();
    $app = new App($di);
    /**
     * 引导程序
     */
    $bootstrap = new \App\BootStrap\BootStrap(
        new \App\BootStrap\ServiceBootstrap(),
        new \App\BootStrap\MiddlewareBootstrap(),
        new \App\BootStrap\EndPointBootstrap()
    );
    /** 运行服务 */
    $bootstrap->run($app, $di, $config);

    /**
     * 捕获请求
     */
    $app->handle();
    // Set appropriate response value
    $response = $app->di->getShared(Services::RESPONSE);

    $returnedValue = $app->getReturnedValue();

    if($returnedValue !== null) {

        if (is_string($returnedValue)) {
            $response->setContent($returnedValue);
        } else {
            $response->setJsonContent($returnedValue);
        }
    }

} catch (Throwable $t) {
    // Handle exceptions
    $di = $app->di ?? new ApiFactory();
    $response = $di->getShared(Services::RESPONSE);
    if(!$response || !$response instanceof Response){
        $response = new Response();
    }
    $debugMode = isset($config->debug) ? $config->debug : (APPLICATION_ENV == 'development');
    #$debugMode = false;
    $response->setErrorContent($t, $debugMode);
}
finally{
    /** @var $response Response */
    if (!$response->isSent()) {
        $response->send();
    }
}
