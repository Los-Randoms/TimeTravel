<?php namespace Modules\Kernel;

abstract class Session {
	static function exists(): bool {
		$cookie_name = session_name();

		if(isset($_COOKIE[$cookie_name]))
			return true;
		
		return false;
	}

	static function started(): bool {
		if(session_status() == PHP_SESSION_ACTIVE)
			return true;
		return false;
	}

	static function create(User $account): bool {
		return true;
	}
}
