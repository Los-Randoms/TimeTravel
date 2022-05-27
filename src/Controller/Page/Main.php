<?php namespace Controller\Page;

use Controller\Component\Navbar;
use Modules\Kernel\Page;
use Modules\Kernel\View;

class Main extends Page {
	public array $publications;

	function __construct() {
		parent::__construct('index.phtml');
		$this->style('css/index.css');
		$this->header[] = new Navbar();
		$this->header[] = new View('component/banner.phtml');
	}
}
