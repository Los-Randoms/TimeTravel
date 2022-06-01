<?php

namespace Modules\Account;

use DateTime;

abstract class Session
{
	/**
	 * Check if the session file exists
	 * @return bool true if the session file exists
	 * */
	static function exists(): bool
	{
		$path = session_save_path();
		$name = session_name();

		if ($ssid = $_COOKIE[$name] ?? false) {
			if (file_exists("$path/sess_$ssid"))
				return true;
		}

		return false;
	}

	/**
	 * Init sessions
	 * */
	static function init() 
	{
		session_start();
		$_SESSION['__last_access'] = new DateTime();
		if(!self::exists()) {
			$_SESSION['account'] = [
				'user' => null,
				'logged' => false,
			];
			$_SESSION['messages'] = [];
		}

		// Check if the user exists
		if($_SESSION['account']['logged']) {
			/** @var User */
			$user = $_SESSION['account']['user'];
			$user = User::load($user->id);
			if(empty($user))
				self::logout();
		}
	}
	static function login(User $user) {
		$_SESSION['account'] = [
			'user' => $user,
			'admin' => $user->rol === 'admin',
			'logged' => true,
		];
	}

	static function logout() {
		$_SESSION['account'] = [
			'user' => null,
			'logged' => false,
		];
	}

	static function stop()
	{
		session_commit();
	}
}
