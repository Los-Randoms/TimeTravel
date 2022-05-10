<?php namespace Modules\Router;
/** @ */

use Exception;
use Modules\Kernel\Page;

abstract class Router {
	static private array $routes = [];
	
	static function file(string $path) {
		$content = file_get_contents($path);
		self::$routes = json_decode($content, true);
	}

	static function exitst(string $path) {
		return isset(self::$routes[$path]);
	}

	static function get(string $path) {
		return self::$routes[$path] ?? null;
	}

	static function current(): Page {
		$path = parse_url($_SERVER['REQUEST_URI'])['path'];
		if(!self::exitst($path))
			throw new Exception('Page not found', 404);
		$route = Router::get($path);
		$page = new $route;
		return $page;
	}
}
