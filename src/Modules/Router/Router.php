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
		if (!self::exitst($path))
			return null;
		$route_class = self::$routes[$path];
		return new Route($path, $route_class);
	}

	static function current(): Controller
	{
		$uri = urldecode($_SERVER['REQUEST_URI']);
		$path = parse_url($uri)['path'];
		if (!self::exitst($path))
			throw new Exception('Page not found', 404);
		$route = Router::get($path);
		return $route->getController();
	}
}
