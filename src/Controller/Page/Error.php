<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Error extends Page {
	function __construct() {
		parent::__construct('error/exception.phtml');
		
	}
}
