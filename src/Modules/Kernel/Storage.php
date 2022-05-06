<?php namespace Modules\Kernel;

use mysqli_stmt;

abstract class Storage {
	static private StorageDriver $driver;

	static function driver(): ?StorageDriver {
		$class = STORAGE['driver'] ?? null;
		$credentials = STORAGE['credentials'] ?? [];
		if(!isset(self::$driver))
			self::$driver = new $class($credentials);
		return self::$driver;
	}

	static function close() {
		if(isset(self::$driver) && !empty(self::$driver))
			unset(self::$driver);
	}
}

interface StorageDriver {
	function create(string $table): InsertQuery;
	function read(string $table): SelectQuery;
	function update(string $table): UpdateQuery;
	function delete(string $table): DeleteQuery;
	function prepare(string $query): StorageStmt|false;
}

interface StorageStmt {
	function bindObject(object &$obj, array $keys = []);
	function bindArray(array $data, array $keys = []);
}

interface SelectQuery {
	function condition(string $field, &$ref, array $opt);
	function select(string $field);
	function groupBy(string $field);
	function limit(int $count, int $offset);
	function orderBy(string $field, array $opt);
}

interface DeleteQuery {
	function condition(string $field, &$ref, array $opt);
	function limit(int $count, int $offset);
}

interface InsertQuery {
	function set(string $field, &$ref);
}

interface UpdateQuery {
	function set(string $field, &$ref);
	function condition(string $field, &$ref, array $opt);
	function orderBy(string $field, array $opt);
	function limit(int $count, int $offset);
}
