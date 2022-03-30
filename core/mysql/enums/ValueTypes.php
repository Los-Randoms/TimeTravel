<?php namespace Core\mysql\enums;

use Core\utils\Enum;

class ValueTypes extends Enum {
	const STRING = 's';
	const INTEGER = 'i';
    const BOOLEAN = 'i';
    const NULL = 'b';

    public function __construct(mixed $value) {
        $type = gettype($value);
        $type = strtoupper($type);
        parent::__construct($type);
    }
}
