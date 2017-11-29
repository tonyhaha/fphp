<?php
namespace Core\engine;

class Action {
    private $route;
    private $method = 'index';

    private $middleware_class = array();

    private $isexist_middleware = false;

    public function __construct($route) {
        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));
        // Break apart the route
        while ($parts) {
            $file = DIR_APP . 'controller/' . implode('/', $parts) . '.php';
            if (is_file($file)) {
                $this->route = implode('/', $parts);
                break;
            } else {
                $this->method = array_pop($parts);
            }
        }
    }

    public function execute($registry,array $args = array()) {

        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            return new \Exception('Error: Calls to magic methods are not allowed!');
        }
        $middleware_config = $registry->get('load')->config('middleware');
        if(isset($middleware_config[$this->route.'/'.$this->method])){
            $this->middleware_class = $middleware_config[$this->route.'/'.$this->method];
        }else{
            foreach($middleware_config as $key=>$val){
                $first = explode('/',$key);
                if($first[0] == $this->route && $first[1] == '*'){
                    $this->middleware_class = $val;
                    break;
                }
            }
        }
        $handlers = array();
        $middleware = new \stdClass();
        if($this->middleware_class){
                $middleware = new $this->middleware_class($registry);
                $this->isexist_middleware = true;
        }
        if($this->isexist_middleware){
            if(method_exists($middleware,"handle")){
                array_push($handlers,array($middleware, 'handle'));
            }
        }

        $class = preg_replace('/[^a-zA-Z0-9]/', '', $this->route);
        $class = "\App\controller\\".$class;
        if (class_exists($class)) {
            $controller = new $class($registry);
        } else {
            return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }
        $reflection = new \ReflectionClass($class);

        if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
            if($this->isexist_middleware) {
                array_push($handlers, array($controller, $this->method));
                if (method_exists($middleware, "terminate")) {
                    array_push($handlers, array($middleware, 'terminate'));
                }

                return (new Callback())->send($args)->through($handlers)->then(function(){});
            }else{
                return call_user_func_array(array($controller, $this->method), $args);
            }

        } else {
            return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }
    }
}
