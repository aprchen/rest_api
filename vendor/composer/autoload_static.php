<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteb5b1aaa5f31e3b1272a71c512346dd7
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
        'G' => 
        array (
            'GatewayClient\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
        'GatewayClient\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/gatewayclient',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteb5b1aaa5f31e3b1272a71c512346dd7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteb5b1aaa5f31e3b1272a71c512346dd7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
