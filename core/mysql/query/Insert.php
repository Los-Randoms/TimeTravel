<?php namespace Core\mysql\query;

use Core\mysql\enums\ValueTypes;
use Core\mysql\part\Values;

class Insert extends Query {
	private string $table;
	private Values $values;

	public function __construct(string $table) {
		$this->table = $table;
		$this->values = new Values();
	}

	public function set(string $column, mixed $value) {
		$type = new ValueTypes($value);
		$this->data_values[] = $value;
		$this->data_types .= $type;
		$this->values->add($column, '?');
	}

	public function __toString(): string {
		$query = "INSERT INTO `{$this->table}` SET {$this->values}";
		return $query;
	}
}

