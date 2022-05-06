<?php namespace Modules\Mysql;

use Modules\Kernel\Stmt as KernelStmt;
use mysqli_stmt;

class Stmt extends mysqli_stmt implements KernelStmt {
	function bindObject(object &$obj, array $keys = []) {
		
	}

	function bindArray(array $data, array $keys = []) {
	}
}
