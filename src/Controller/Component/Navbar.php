<?php namespace Controller\Component;

use Modules\Kernel\View;

class Navbar extends View {
	function __construct() {
		parent::__construct('component/navbar.phtml');
	}
}
