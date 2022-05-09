<?php namespace Modules\Mysql;

use Error;
use Modules\Kernel\Query as KernelQuery;
use mysqli_result;
use mysqli_stmt;

abstract class Query implements KernelQuery {
	protected bool $ready = false;
	protected Driver $driver;
	protected string $table;
	protected mysqli_result $result;
	protected mysqli_stmt $stmt;

	function __construct(Driver $driver, string $table) {
		$this->driver = $driver;
		$this->table = $table;
	}

	function reset() {
		$this->ready = false;
		$this->stmt->reset();
	}

	protected function exec(string $types, array $refs) {
		if(!$this->ready) {
			$this->stmt = $this->driver->prepare($this);
			if(!empty($this->condTypes))
				$this->stmt->bind_param($types, ...$refs);
		}
		$this->stmt->execute();
		if(isset($this->result))
			$this->result->free();
		$result = $this->stmt->get_result();
		if($result !== false)
			$this->result = $result;
	}

	function fetch(?string $class = null): object|array|null {
		if(!isset($this->result))
			throw new Error('Querys cannot be fethed after execute');
		if($this->result->field_count < 1)
			return null;
		if(empty($class))
			return $this->result->fetch_assoc();
		return $this->result->fetch_object($class);
	}

	function results(?string $class = null): array {
		$results = [];
		while($row = $this->fetch($class))
			$results[] = $row;
		return $results;
	}

	function __destruct() {
		if(isset($this->result) && !empty($this->result))
			$this->result->free();
		if(isset($this->stmt) && !empty($this->stmt))
			$this->stmt->close();
	}
}
