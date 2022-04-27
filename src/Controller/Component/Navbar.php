<?php namespace Controller\Component;

use Modules\Kernel\User;
use Modules\Kernel\View;

class Navbar extends View {
	public User $user;

	function __construct() {
		parent::__construct('component/navbar.phtml');
	}
}
