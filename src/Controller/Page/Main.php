<?php namespace Controller\Page;

use Controller\Component\Navbar;
use Modules\Account\Session;
use Modules\Kernel\Page;
use Modules\Kernel\View;

class Main extends Page {
	public array $publications;

	function __construct() {
		parent::__construct('index.phtml');
		$this->style('css/index.css');
		$this->header[] = new Navbar();
		$this->header[] = new View('component/banner.phtml');
		echo '<pre>';
		if(Session::started())
			print_r($_SESSION['user']);
		echo '</pre>';
	}
}
