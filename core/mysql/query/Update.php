<?php namespace Core\mysql\query;

use Core\mysql\enums\ValueTypes;
use Core\mysql\part\Conditions;
use Core\mysql\part\Values;
use Core\mysql\enums\Conditionals as EnumConditionals;
use Core\mysql\enums\Operators as EnumOperatots;

class Update extends Query {
	private string $table;
	private Values $values;
	private Conditions $conditions;

	public function __construct(string $table) {
		$this->table = $table;
		$this->values = new Values();
		$this->conditions = new Conditions();
	}

	public function set(string $column, mixed $value) {
		$type = new ValueTypes($value);
		$this->data_values[] = $value;
		$this->data_types .= $type;
		$this->values->add($column, '?');
	}

	public function condition(
		string $column, 
		mixed $value,
		string $conditional = EnumConditionals::EQUALS,
		string $operator = EnumOperatots::AND
	) {
		$conditional = new EnumConditionals($conditional);
		$type = new ValueTypes($value);

		$condition = "$column $conditional ?";
		$this->data_values[] = $value;
		$this->data_types .= $type;
		$this->conditions->add($condition, $operator);
	}

	public function __toString(): string {
		$query = "UPDATE `{$this->table}` SET {$this->values}";
		if($conditions = $this->conditions->__toString())
			$query .= " WHERE $conditions";
		return $query;
	}
}


