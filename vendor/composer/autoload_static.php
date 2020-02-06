<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite04e9178da2aba25e91f1685a2e76849
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
    );

    public static $classMap = array (
        'Admin' => __DIR__ . '/../..' . '/Models/Admin.php',
        'AdminController' => __DIR__ . '/../..' . '/Controllers/AdminController.php',
        'Artist' => __DIR__ . '/../..' . '/Models/Artist.php',
        'ArtistController' => __DIR__ . '/../..' . '/Controllers/ArtistController.php',
        'Controller' => __DIR__ . '/../..' . '/Controllers/Controller.php',
        'Films' => __DIR__ . '/../..' . '/Models/Films.php',
        'HomeController' => __DIR__ . '/../..' . '/Controllers/HomeController.php',
        'Model' => __DIR__ . '/../..' . '/Models/Model.php',
        'NotFoundController' => __DIR__ . '/../..' . '/Controllers/NotFoundController.php',
        'Route' => __DIR__ . '/../..' . '/Router/Route.php',
        'Router' => __DIR__ . '/../..' . '/Router/Router.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite04e9178da2aba25e91f1685a2e76849::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite04e9178da2aba25e91f1685a2e76849::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite04e9178da2aba25e91f1685a2e76849::$classMap;

        }, null, ClassLoader::class);
    }
}
