<?php namespace Core\mysql\query;

use Core\mysql\enums\Conditionals as EnumsConditionals;
use Core\mysql\enums\Operators as EnumsOperators;
use Core\mysql\enums\ValueTypes;
use Core\mysql\part\Columns;
use Core\mysql\part\Conditions;

class Select extends Query {
	private string $table;
	public Columns $columns;
	public Conditions $conditions;

	public function __construct(string $table) {
		$this->table = $table;
		$this->columns = new Columns();
		$this->conditions = new Conditions();
	}

	public function condition(
		string $column, 
		mixed $value,
		string $conditional = EnumsConditionals::EQUALS,
		string $operator = EnumsOperators::AND
	) {
		$conditional = new EnumsConditionals($conditional);
		$type = new ValueTypes($value);

		$condition = "$column $conditional ?";
		$this->data_values[] = $value;
		$this->data_types .= $type;
		$this->conditions->add($condition, $operator);
	}

	public function __toString(): string {
		$query = "SELECT {$this->columns} FROM `{$this->table}`";
		if($conditions = $this->conditions->__toString())
			$query .= " WHERE $conditions";
		return $query;
	}
}
