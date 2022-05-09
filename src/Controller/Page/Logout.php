<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Logout extends Page {
	public array $publicaciones;
	function __construct() {
		unset($_SESSION['uid']);
		session_start();
		session_unset();
		session_write_close();
		session_destroy();
		header('Location: /');
	}
}
