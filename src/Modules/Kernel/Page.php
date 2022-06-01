<?php

namespace Modules\Kernel;

use Exception;
use Modules\Account\Session;
use ReflectionClass;
use ReflectionMethod;

abstract class Page extends View
{
	protected App $app;

	function __construct(App $app) {
		$this->app = $app;
	}
}
