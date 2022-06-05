<?php

namespace Modules\Account;

use Modules\Kernel\File;
use Modules\Kernel\Message;

abstract class Session
{
	static protected bool $logged = false;

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
		if (!self::exists())
			return false;
		
		session_start();
		$user = $_SESSION['user'];
		$_SESSION['user'] = User::load($user->id);
		if (empty($user) || $user->banned) {
			if ($user->banned)
				Message::add('Ha sido baneado');
			return self::logout();
		}
		self::$logged = true;
		return true;
	}

	static function login(User $user)
	{
		session_start();
		$_SESSION['user'] = $user;
		$_SESSION['is_admin'] = $user->rol === 'admin';
		if (!empty($user->avatar))
			$_SESSION['pfp'] = File::load($user->avatar);
	}

	/**
	 * Cerrar la session
	 * */
	static function logout()
	{
		$_SESSION['user'] = null;
		$_SESSION['is_admin'] = false;
		$_SESSION['pfp'] = null;
		session_destroy();
	}

	/**
	 * Guardar la session
	 * */
	static function save()
	{
		session_commit();
	}

	/**
	 * La sesion ha sido iniciada
	 * */
	static function logged(): bool
	{
		return self::$logged;
	}
}
