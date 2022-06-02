<?php

namespace Modules\Router;

use Modules\Kernel\Controller;

class Route
{
	private string $path;
	private string $controller_class;

	function __construct(string $path, string $class) {
		$this->path = $path;
		$this->controller_class = $class;
	}
	
	function getPath(): string {
		return $this->path;
	}

	function getControllerClass(): string {
		return $this->controller_class;
	}

	function getController(): Controller {
		return new $this->controller_class;
	}
}
