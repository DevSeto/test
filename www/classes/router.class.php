<?php

class Router extends Strict {

	private $default_controller;
	private $controllers_path;

	public function __construct() {
		
	}

	public function setControllersPath($pathname) {
		$this->controllers_path = $pathname;
	}

	public function setDeafaultController($controller) {
		$this->default_controller = $controller;
	}

	public function loadController($route_string) {
		$route_string = trim($route_string, '/');
		$path_parts = explode("/", $route_string);

		$controller_info['path'] = $this->controllers_path;
		$controller_info['name'] = 'Controller_login';
		$controller_info['file'] = 'login.php';
		$controller_info['function'] = 'index';

		foreach ($path_parts as $part) {

			if (is_dir($controller_info['path'] . "/" . $part)) {
				$controller_info['path'] .= "/" . $part;
				array_shift($path_parts);
				continue;
			}

			if (is_file($controller_info['path'] . "/" . $part . ".php")) {
				$controller_info['file'] = $part . ".php";
				$controller_info['name'] = 'Controller_' . $part;

				array_shift($path_parts);
				$controller_info['function'] = !empty($path_parts[0]) ? $path_parts[0] : 'index';
				break;
			}

			die('no such controller');
		}

		include_once $controller_info['path'] . "/" . $controller_info['file'];

		$controller = new $controller_info['name'];


		if (method_exists($controller, $controller_info['function'])) {
			call_user_func(array($controller, $controller_info['function']));
		} else {
			$controller_info['function'] = index;
			if (method_exists($controller, $controller_info['function'])) {
				call_user_func(array($controller, $controller_info['function']));
			} else {
				die("method doesn't excists");
			}
		}
	}

}
