<?php namespace Modules\Kernel;

abstract class Session {
	public static function isLogged(): bool {
		$cookie_name = session_name();
		if(!isset($_COOKIE[$cookie_name]))
			return false;
		session_start();
		if(!isset($_SESSION['uid'])) {
			session_destroy();
			return false;
		}
		return true;
	}

	public static function currentUser(): ?User {
		if(!static::isLogged())
			return null;
		$user = User::load($_SESSION['uid']);
		return $user;
	}
}
