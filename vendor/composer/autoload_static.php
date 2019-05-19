<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8845fbbf5fb7e66ce8404e2c2017b68b
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
    );

    public static $prefixesPsr0 = array (
        'o' => 
        array (
            'org\\bovigo\\vfs' => 
            array (
                0 => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8845fbbf5fb7e66ce8404e2c2017b68b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8845fbbf5fb7e66ce8404e2c2017b68b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit8845fbbf5fb7e66ce8404e2c2017b68b::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}