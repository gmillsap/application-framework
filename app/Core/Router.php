<?php
namespace GAF\Core;

/**
 * Class Router
 *
 * Short Description: Router class that handles determine the controller and method that needs to be called be specific
 * urls.
 *
 * @package GAF\Core
 *
 * @author Cole Millsap
 */
class Router
{
    protected $uri;
    protected $access_method;
    protected $controller_class;
    protected $controller_method;

    public function __construct() {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->access_method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->fetchControllerClass();
        $this->fetchControllerMethod();
    }

    /**
     * Short Description: Simple getter.
     *
     * @return string
     *
     * @author Cole Millsap
     */
    public function getAccessMethod() {
        return $this->access_method;
    }

    /**
     * Short Description: Simple getter.
     *
     * @return mixed
     *
     * @author Cole Millsap
     */
    public function getControllerClass() {
        return $this->controller_class;
    }

    /**
     * Short Description: Simple getter.
     *
     * @return mixed
     *
     * @author Cole Millsap
     */
    public function getControllerMethod() {
        return $this->controller_method;
    }

    /**
     * Short Description: Finds the class that the URI is attempting to access.
     *
     * @return $this
     *
     * @author Cole Millsap
     */
    public function fetchControllerClass() {
        $path = strtolower(ltrim($this->uri, '/'));
        $path = str_replace(' ', '/', ucwords(str_replace('/', ' ', $path)));
        $path = ucwords(str_replace('-', ' ', $path));
        $path = str_replace(' ', '', $path);
        $class = str_replace('/', '\\', $path);
        $is_index = (substr($path, -1) === '/' ? true : false);
        if ($is_index) {
            $this->controller_class = rtrim($class, '\\');
            return $this;
        }
        $this->controller_class = substr($class, 0, strrpos($class, '\\'));
        return $this;
    }

    /**
     * Short Description: Finds the method that the UIR is attempting to access. If the URI ends in a / then this will
     * return 'index'.
     *
     * @return $this
     *
     * @author Cole Millsap
     */
    public function fetchControllerMethod() {
        $path = $this->uri;
        $is_index = (substr($path, -1) === '/' ? true : false);
        if ($is_index) {
            $this->method = 'index';
            return $this;
        }
        $method = ltrim(substr($path, strrpos($path, '/'), strlen($path)), '/');
        $method = explode('?', $method);
        $this->controller_method = $this->access_method . ucfirst($method[0]);
        return $this;
    }
}