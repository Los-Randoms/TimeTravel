<?php namespace Modules\Kernel;

use Exception;
use Error;

class ErrorPage extends Controller {
	private Error|Exception $error;

	function __construct(Error|Exception $error) {
		if($error->getCode() !== 0)
			http_response_code($error->getCode());
		else
			http_response_code(500);
		$this->error = $error;
	}

	function content() {
		$view = new View("error/{$this->error->getCode()}.phtml");
		if(!file_exists($view->path()))
			$view = new View("error/0.phtml");
		$view->set('error', $this->error);
		return $view;
	}
}
