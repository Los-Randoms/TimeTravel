<?php namespace Core\session;

use Core\mysql\Database;

class Session {
	private static Session $current;
	private bool $is_logged = false;
	private User $user;

	static public function current_session() {
		if(!isset(self::$current))
			self::$current = new self();
		return self::$current;
	}

	private function __construct() {
		$this->is_logged = session_status() == PHP_SESSION_ACTIVE;
		if($this->is_logged) {
			session_start();
			$db = Database::instance();
			$storage = $db->storage(User::class);
			$user_id = $_SESSION['user_id'] ?? 0;
			$user = $storage->get($user_id);
			$this->user = $user;
		}
	}

	public function isLogged(): bool {
		return $this->is_logged;
	}

	public function getUser(): User {
		return $this->user;
	}
}
