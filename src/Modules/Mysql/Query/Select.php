<?php namespace Modules\Mysql\Query;

use Modules\Kernel\SelectQuery;
use Modules\Mysql\Driver;

class Select extends Query implements SelectQuery {
	private Driver $db = $db;
	private string $table;

	function __construct(Driver $db, string $table) {
		$this->db = $db;
		$this->table = $table;
	}

	function condition(string $field, &$ref, array $opt) {
		
	}

	function select(string $field) {
		
	}

	function groupBy(string $field) {
		
	}

	function orderBy(string $field, array $opt) {
		
	}

	function limit(int $count, int $offset) {
		
	}
}
