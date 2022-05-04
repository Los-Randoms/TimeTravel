<?php namespace Controller\Page;

use Modules\Kernel\Page;

class NotFound extends Page {
	function __construct() {
		parent::__construct('error/not_found.phtml');
	}
}
