<?php namespace Modules\Mysql\Query;

use Error;
use Modules\Kernel\Insert as KernelInsert;
use Modules\Mysql\Query;
use Modules\Mysql\Traits\QuerySetTrait;

class Insert extends Query implements KernelInsert {
	use QuerySetTrait;

	function execute(): bool {
		$this->exec($this->setTypes, ...$this->setValues);
		return true;
	}

	function insertId(): int {
		if(!isset($this->stmt))
			throw new Error('Cannot get insert id after execution');
		return $this->stmt->insert_id;
	}

	function __toString(): string {
		return "INSERT INTO `$this->table` SET {$this->setPart}";
	}
}
