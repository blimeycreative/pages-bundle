<?php

// autoload_real.php generated by Composer

require __DIR__ . '/ClassLoader.php';

class ComposerAutoloaderInit
{
    private static $loader;

    public static function getLoader()
    {
        if (null !== static::$loader) {
            return static::$loader;
        }

        static::$loader = $loader = new \Composer\Autoload\ClassLoader();
        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);

        $map = require __DIR__ . '/autoload_namespaces.php';
        foreach ($map as $namespace => $path) {
            $loader->add($namespace, $path);
        }

        $classMap = require __DIR__ . '/autoload_classmap.php';
        if ($classMap) {
            $loader->addClassMap($classMap);
        }

        spl_autoload_register(array('ComposerAutoloaderInit', 'autoload'));

        $loader->register();

        return $loader;
    }

    public static function autoload($class)
    {
        $dir = dirname(dirname(__DIR__)) . '/';
        $prefixes = array('Savvy\\PagesBundle');
        foreach ($prefixes as $prefix) {
            if (0 !== strpos($class, $prefix)) {
                continue;
            }
            $path = $dir . implode('/', array_slice(explode('\\', $class), 2)).'.php';
            if (!$path = stream_resolve_include_path($path)) {
                return false;
            }
            require $path;

            return true;
        }
    }
}
