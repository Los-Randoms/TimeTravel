<?php

namespace Modules\Kernel;

use Exception;
use Error;
use Throwable;

class ErrorPage extends Controller
{
	private Throwable $error;

	function __construct(Error|Exception $error)
	{
		$this->error = $error;
	}

	function content()
	{
		$view = new View("error/{$this->error->getCode()}.phtml");
		if (!file_exists($view->path()))
			$view = new View("error/0.phtml");
		$view->set('error', $this->error);
		return $view;
	}
}
