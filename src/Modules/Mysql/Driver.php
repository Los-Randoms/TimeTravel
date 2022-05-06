<?php namespace Modules\Mysql;

use Modules\Kernel\DeleteQuery;
use Modules\Kernel\InsertQuery;
use Modules\Kernel\SelectQuery;
use Modules\Kernel\StorageDriver;
use Modules\Kernel\UpdateQuery;
use Modules\Mysql\Query\Delete;
use Modules\Mysql\Query\Insert;
use Modules\Mysql\Query\Select;
use Modules\Mysql\Query\Update;
use mysqli;

mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
class Driver extends mysqli implements StorageDriver {
	function __construct() {
		$this->connect(...STORAGE['credentials'] ?? []);
	}

	function __destruct() {
		$this->close();
	}

	function prepare(string $query): Stmt|false {
		return new Stmt($this, $query);
	}

	function create(string $table): InsertQuery {
		return new Insert($this);
	}

	function read(string $table): SelectQuery {
		return new Select($this);
	}

	function update(string $table): UpdateQuery {
		return new Update($this);
	}
	
	function delete(string $table): DeleteQuery {
		return new Delete($this);
	}
}


/*
trait setQuery { }
trait limitQuery { }
trait orderQuery { }
trait groupQuery { }
trait selectQuery { }

*/
