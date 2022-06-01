<?php namespace Modules\Kernel;

class App {
	private View $page;

	function __construct() {
		$this->page = new View('page.phtml');
	}

	function init() {}
}
