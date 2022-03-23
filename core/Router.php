<?php namespace Core;

class Router {
	private array $routes;
	static private self $instance;

	static public function instance(): self {
		if(!isset(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}

	private function __construct() {
		$this->routes = yaml_parse_file("$_SERVER[SITE_DIR]/{$_ENV['site']['routes']}");
	}

	public function get(string $path) {
		$route = $this->routes[$path] ?? null;
		if($route) {
			$controller = explode('::', $route['controller'], 2);
			$route['controller'] = [
				'class' => $controller[0],
				'function' => $controller[1],
			];
		}
		return $route;
	}
}
