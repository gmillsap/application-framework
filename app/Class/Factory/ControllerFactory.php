<?php
namespace Factory;

class ControllerFactory
{
    protected static $controller_dir = 'Controller';

    static public function build($class) {
        if (strpos($class, self::$controller_dir) !== 0) {
            $class = self::$controller_dir . '\\' . $class;
        }
        if (class_exists($class)) {
            return new $class;
        } else {
            return self::fetchBaseController($class);
        }
    }

    static public function fetchBaseController($class) {
        $base_class = substr($class, 0, strrpos($class, '\\') + 1) . 'Base';
        if (class_exists($base_class)) {
            return new $base_class;
        }
        return null;
    }
}