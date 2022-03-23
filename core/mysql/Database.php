<?php namespace Core\mysql;
use mysqli;

class Database extends mysqli {
	static private self $instance;

	static public function instance(): self {
		if(!isset(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}

	private function __construct() {
		$this->connect(...$_ENV['mysql']);
	}

	public function storage(string $T) {
		return new Storage($this, $T);
	}
}
