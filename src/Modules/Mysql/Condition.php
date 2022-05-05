<?php namespace Modules\Mysql;

trait Condition {
	
	/*
	public function condition(
		string $field, 
		mixed $value, 
		Operators $operator = Operators::EQUALS,
		ConditionType $type = ConditionType::AND
	) {
		$condition = "$field {$operator->value} ?";
		if(!empty($this->conditions))
			$condition = " {$type->value} $condition";
		$this->conditions .= $condition;

		$this->bind('', $value);
	}
	 */
}
