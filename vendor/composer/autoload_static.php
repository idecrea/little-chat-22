<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6ec4a177a1c4d1927ab28700c8f2ad3a
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6ec4a177a1c4d1927ab28700c8f2ad3a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6ec4a177a1c4d1927ab28700c8f2ad3a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
