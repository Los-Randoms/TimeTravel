<?php namespace Modules\Kernel;

class Session {
	static private Session $current;
	private string $ssid;
	private User $user;

	public function __construct() {
		echo session_name();
		die;
	}
}
