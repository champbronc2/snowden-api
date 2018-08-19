<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc120c79a9294fbef8eb71a64ff0e4d84
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $prefixesPsr0 = array (
        'R' => 
        array (
            'Requests' => 
            array (
                0 => __DIR__ . '/..' . '/rmccue/requests/library',
            ),
        ),
        'P' => 
        array (
            'PubNub\\' => 
            array (
                0 => __DIR__ . '/..' . '/pubnub/pubnub/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc120c79a9294fbef8eb71a64ff0e4d84::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc120c79a9294fbef8eb71a64ff0e4d84::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitc120c79a9294fbef8eb71a64ff0e4d84::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
