<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Main extends Page {
	function __construct() {
		parent::__construct('index.phtml');
		$this->setTitle('Time travel');
	}
}
