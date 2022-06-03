<?php

namespace Modules\Account;

use DateTime;
use Modules\Kernel\File;

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
		if (!self::exists()) {
			$_SESSION['account'] = [
				'user' => null,
				'logged' => false,
			];
			$_SESSION['messages'] = [];
		}

		// Check if the user exists
		if ($_SESSION['account']['logged']) {
			/** @var User */
			$user = $_SESSION['account']['user'];
			$user = User::load($user->id);
			if (empty($user) || $user->banned)
				return self::logout();
			$pfp = null;
			if(!empty($user->avatar))
				$pfp = File::load($user->avatar);
			$_SESSION['account']['user'] = $user;
			$_SESSION['account']['pfp'] = $pfp;
			$_SESSION['__last_access'] = new DateTime();
		}
	}
	static function login(User $user)
	{
		$picture = null;
		if (!empty($user->avatar))
			$picture = File::load($user->avatar);
		$_SESSION['account'] = [
			'user' => $user,
			'pfp' => $picture,
			'admin' => $user->rol === 'admin',
			'logged' => true,
		];
	}

	static function logout()
	{
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
