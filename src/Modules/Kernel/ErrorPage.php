<?php

namespace Modules\Kernel;

use Throwable;

class ErrorPage extends Controller
{
	private Throwable $error;

	function __construct(Throwable $error)
	{
		$this->error = $error;
		$this->styles[] = 'error.css';
	}
	function title(): string
	{
		return 'ERROR';
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
