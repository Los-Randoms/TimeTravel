<?php namespace Modules\Kernel;

use Exception;
use Error;

class ErrorPage extends Page {
	private Error|Exception $error;

	function __construct(Error|Exception $error) {
		parent::__construct($file);
		http_response_code($code);
		$this->error = $error;
	}

	function message(): string {
		return $this->error->getMessage();
	}

	function trace(): string {
		return $this->error->getTraceAsString();
	}

	function file(): string {
		return $this->error->getFile() . ':' . $this->error->getLine();
	}
}
