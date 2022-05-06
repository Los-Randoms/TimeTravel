<?php namespace Modules\Mysql\Query;

use Modules\Kernel\InsertQuery;
use Modules\Mysql\Driver;

class Insert implements InsertQuery {
	private Driver $db = $db;

	function __construct(Driver $db) {
		$this->db = $db;
	}

	function set(string $field, &$ref) {
		
	}
}
