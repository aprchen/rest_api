<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('VENDOR_DIR', BASE_PATH . '/vendor');
define('CONFIG_DIR', APP_PATH . '/config');

/** 扩展检查 */
if(!extension_loaded('phalcon'))
{
    exit("Please install phalcon extension. See https://phalconphp.com/zh/ \n");
}

/** @var \Phalcon\Config $config */
$config = null;

require_once VENDOR_DIR . '/autoload.php';
if(file_exists(CONFIG_DIR."/env.local.php")){
    define('APPLICATION_ENV','local');
}else{
    define('APPLICATION_ENV', 'pro');
}

try {

    /**
     *默认DI 容器
     */
    $di = new FactoryDefault();

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
        "App"=>APP_PATH
    ]);
    $loader->registerDirs(
        [
            $config->application->modelsDir
        ]
    )->register();


    $app = new Micro($di);

    /**
     * 引导程序
     */
    $bootstrap = new \App\BootStrap\BootStrap(
        new \App\BootStrap\ServiceBootstrap(),
        new \App\BootStrap\MiddlewareBootstrap(),
        new \App\BootStrap\EndPointBootstrap()
    );
    /** 运行服务 */
    $bootstrap->run($app,$di,$config);

    /**
     * 捕获请求
     */
    $app->handle();

} catch (Throwable $t) {
      echo $t->getMessage() . '<br>';
      echo $t->getFile() .$t->getLine().'<br>';
      echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
