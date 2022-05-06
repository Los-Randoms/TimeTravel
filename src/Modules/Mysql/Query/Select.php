<?php namespace Modules\Mysql\Query;

use Modules\Kernel\SelectQuery;
use Modules\Mysql\Driver;

class Select implements SelectQuery {
	private Driver $db = $db;

	function __construct(Driver $db) {
		$this->db = $db;
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
