<?php

namespace Modules\Account;

use Modules\Kernel\File;
use Modules\Kernel\Message;

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
		if (!self::exists())
			self::logout();

		// Check if the user exists
		if ($_SESSION['logged']) {
			$user = &$_SESSION['account'];
			$_SESSION['account'] = User::load($user['id']);
			if (empty($user) || $user['banned']) {
				if($user['banned'])
					Message::add('Ha sido baneado');
				return self::logout();
			}
		}
	}
	static function login(User $user)
	{
		$_SESSION['account'] = (array) $user;
		$_SESSION['is_admin'] = $user->rol === 'admin';
		$_SESSION['logged'] = true;
		if (!empty($user->avatar))
			$_SESSION['pfp'] = File::load($user->avatar);
	}

	static function logout()
	{
		$_SESSION['account'] = null;
		$_SESSION['logged'] = false;
		$_SESSION['messages'] = [];
		$_SESSION['is_admin'] = false;
		$_SESSION['pfp'] = null;
	}

	static function stop()
	{
		session_commit();
	}
}
