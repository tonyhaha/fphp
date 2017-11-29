<?php
namespace Core\engine;

use Core\engine\Router;
class Loader {
	protected $registry;

	public function __construct($registry) {
		$this->registry = $registry;
	}


	public function bootstrap($registry){
		$load = $this->config('load');
		$router = \Core\engine\Router::get();
		$router = explode('/', $router);
		if($load){
			if(isset($load[$router[0]])){
					foreach($load[$router[0]] as $key=>$val){
						$registry->set($key,new $val());
					}
			}
		}
	}

	public function view($route, $data = array()) {
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		foreach ($data as $key => $value) {
			$tmp[$key] = $value;
		}
		$file = ROOT . '/app/view/'.$route . '.php';
		if (file_exists($file)) {
			extract($data);
			ob_start();
			require($file);
			$output = ob_get_contents();
			ob_end_clean();
		} else {
			trigger_error('Error: Could not load template ' . $file . '!');
			exit();
		}
		return $output;
	}
	
	public function helper($route) {
		$file = DIR_CORE . 'helper/' . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route) . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load helper ' . $route . '!');
		}
	}
	
	public function config($route) {
		$file = ROOT . '/config/' . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route) . '.php';

		if (is_file($file)) {
			return include_once($file);
		} else {
			throw new \Exception('Error: Could not load config ' . $route . '!');
		}
	}


}