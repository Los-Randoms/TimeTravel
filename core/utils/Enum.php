<?php namespace Core\utils;

use Error;
use ReflectionClass;

abstract class Enum {
	protected int|string $value;
	static protected bool $valid_name = false;
	private bool $is_value = false;

	public function __construct(int|string $val) {
		$this->is_value = static::validValue($val);
		if(!static::validName($val) && !$this->is_value)
			throw new Error("'$val' is not valid");

		$this->value = $val;
		if(!static::$valid_name && !$this->is_value)
			$this->value = constant("static::$val");
	}

	public function __toString(): string {
		return $this->value;
	}

	static function valid(int|string $data): bool {
		return static::validName($data) || static::validValue($data);
	}

	static function validName(string $name): bool {
		$rfl = new ReflectionClass(static::class);
		return $rfl->hasConstant($name);
	}

	static function validValue(int|string $value): bool {
		$rfl = new ReflectionClass(static::class);
		$const = $rfl->getConstants();
		return in_array($value, $const);
	}
}
