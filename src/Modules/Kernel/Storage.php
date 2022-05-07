<?php namespace Modules\Kernel;

abstract class Storage {
	static private Driver $driver;

	static function driver(): ?Driver {
		$class = STORAGE['driver'] ?? null;
		$credentials = STORAGE['credentials'] ?? [];
		if(!isset(self::$driver))
			self::$driver = new $class(...$credentials);
		return self::$driver;
	}

	static function close() {
		if(isset(self::$driver) && !empty(self::$driver))
			unset(self::$driver);
	}
}

abstract class Query {
	protected Driver $driver;
	protected string $table;

	function __construct(Driver $driver, string $table) {
		$this->driver = $driver;
		$this->table = $table;
	}

	abstract function row(string $class): object|array;
	abstract function results(string $class): array;
	abstract function execute();
	abstract function __toString();
}

interface Driver {
	function create(string $table): Insert;
	function read(string $table): Select;
	function update(string $table): Update;
	function delete(string $table): Delete;
}

interface Select {
	function condition(string $field, &$ref, array $opt);
	function select(string $field);
	function groupBy(string $field);
	function limit(int $count, int $offset);
	function orderBy(string $field, array $opt);
}

interface Delete {
	function condition(string $field, &$ref, array $opt);
	function limit(int $count, int $offset);
}

interface Insert {
	function set(string $field, &$ref);
}

interface Update {
	function orderBy(string $field, array $opt);
	function limit(int $count, int $offset);
}

