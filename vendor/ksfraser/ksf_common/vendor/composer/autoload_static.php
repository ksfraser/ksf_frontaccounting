<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc4136f773bae37b2b3326b6f519930d1
{
    public static $prefixLengthsPsr4 = array (
        'k' => 
        array (
            'ksfraser\\ksf_common\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ksfraser\\ksf_common\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc4136f773bae37b2b3326b6f519930d1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc4136f773bae37b2b3326b6f519930d1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
