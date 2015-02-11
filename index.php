<?php
require_once('app/config.php');
$router = new \GAF\Router();

$controller_class = $router->getControllerClass();
if(empty($controller_class)) {
    $controller = new \Controller\Root();
} else {
    error_log($_SERVER['REQUEST_URI']);
    $controller = \Factory\ControllerFactory::build($router->getControllerClass());
    if (!$controller instanceof Controller\Primative) {
        Controller\ControllerBase::redirect(404, '/404.php');
        exit;
    }
}

$method = $router->getControllerMethod();
if (!method_exists($controller, $method)) {
    Controller\ControllerBase::redirect(404, '/404.php');
    exit;
}
$controller->before();
$controller->$method();
$controller->after();
