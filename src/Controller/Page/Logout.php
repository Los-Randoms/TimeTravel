<?php namespace Controller\Page;

use Modules\Account\Session;
use Modules\Kernel\Page;
use Modules\Kernel\Response;

class Logout extends Page {
	public array $publicaciones;
	function __construct() {
		Session::close();
	}
}
