<?php namespace Modules\Mysql;

use Modules\Kernel\InsertQuery;
use Modules\Kernel\StorageDriver;
use mysqli;

mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
class Driver implements StorageDriver {
	function __construct() {
		$this->connect(...STORAGE['crendentials']);
	}

	function __destruct() {
		$this->close();
	}

}

/*
trait setQuery { }
trait limitQuery { }
trait orderQuery { }
trait groupQuery { }
trait selectQuery { }

*/
