<?php
require_once('app/config.php');
$router = new \GAF\Router();
$controller = $router->getControllerClass();
$method = $router->getControllerMethod();
echo $controller . '->' . $method;
