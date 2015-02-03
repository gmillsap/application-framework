<?php
define('SITE_ROOT', dirname(dirname(__FILE__))."/");
define('APP_DIR', SITE_ROOT . 'app/');
function gaf_autoload($class) {
    $classname = str_replace('\\', '/', $class);
    if (file_exists(APP_DIR . 'Core/' . $classname . '.php')) {
        require_once(APP_DIR . 'Core/' . $classname . '.php');
    } elseif (file_exists(APP_DIR . 'Class/' . $classname . '.php')) {
        require_once(APP_DIR . 'Class/' . $classname . '.php');
    }
}
spl_autoload_register('gaf_autoload', false, true);
