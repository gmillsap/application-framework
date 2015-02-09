<?php
define('SITE_ROOT', dirname(dirname(__FILE__))."/");
define('APP_DIR', SITE_ROOT . 'app/');
function gaf_autoload($class) {
    $classname = str_replace('\\', '/', $class);
    if (file_exists(APP_DIR . 'Library/' . $classname . '.php')) {
        require_once(APP_DIR . 'Library/' . $classname . '.php');
    }
}
spl_autoload_register('gaf_autoload', false, true);
