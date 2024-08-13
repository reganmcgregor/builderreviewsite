<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3f730da16e94e5b18db02e5b92fd5f03
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'enshrined\\svgSanitize\\' => 22,
        ),
        'B' => 
        array (
            'Benjaminzekavica\\EasySvg\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'enshrined\\svgSanitize\\' => 
        array (
            0 => __DIR__ . '/..' . '/enshrined/svg-sanitize/src',
        ),
        'Benjaminzekavica\\EasySvg\\' => 
        array (
            0 => __DIR__ . '/../..' . '/easy-svg.php',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3f730da16e94e5b18db02e5b92fd5f03::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3f730da16e94e5b18db02e5b92fd5f03::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3f730da16e94e5b18db02e5b92fd5f03::$classMap;

        }, null, ClassLoader::class);
    }
}