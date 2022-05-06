<?php namespace Modules\Mysql\Query;

use Modules\Kernel\UpdateQuery;
use Modules\Mysql\Driver;

class Update implements UpdateQuery {
	private Driver $db = $db;

	function __construct(Driver $db) {
		$this->db = $db;
	}

	function set(string $field, &$ref) {
		
	}

	function condition(string $field, &$ref, array $opt) {
		
	}

	function orderBy(string $field, array $opt) {
		
	}

	function limit(int $count, int $offset) {
		
	}
}
