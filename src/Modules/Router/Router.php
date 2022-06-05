<?php

namespace Modules\Router;

use Exception;
use Modules\Kernel\Controller;

abstract class Router
{
	static private array $routes = [];

	static function file(string $path)
	{
		$content = file_get_contents($path);
		self::$routes = json_decode($content, true);
	}

	static function exitst(string $path): bool
	{
		return isset(self::$routes[$path]);
	}

	static function get(string $path): ?Route
	{
		$uri = urldecode($path);
		$uri_path = parse_url($uri)['path'];
		if (!self::exitst($uri_path))
			return null;
		$route_class = self::$routes[$uri_path];
		$route = new Route($uri_path, $route_class);
		$route->route = $path;
		return $route;
	}

	static function current(): Controller
	{
		$route = self::get($_SERVER['REQUEST_URI']);
		if (!isset($route))
			throw new Exception('Page not found', 404);
		return $route->getController();
	}
}
