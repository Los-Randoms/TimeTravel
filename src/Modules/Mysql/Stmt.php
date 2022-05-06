<?php namespace Modules\Mysql;

use Modules\Kernel\StorageStmt;
use mysqli_stmt;

class Stmt extends mysqli_stmt implements StorageStmt {
	function bindObject(object &$obj, array $keys = []) {
		
	}

	function bindArray(array $data, array $keys = []) {
	}
}
