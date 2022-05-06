<?php namespace Modules\Mysql\Query;

use Modules\Kernel\DeleteQuery;
use Modules\Mysql\Driver;

class Delete implements DeleteQuery {
	private Driver $db = $db;

	function __construct(Driver $db) {
		$this->db = $db;
	}

	function condition(string $field, &$ref, array $opt) {
		
	}

	function limit(int $count, int $offset) {
		
	}
}
