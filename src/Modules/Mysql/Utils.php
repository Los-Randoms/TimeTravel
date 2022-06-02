<?php

namespace Modules\Mysql;

use Error;

final class Utils
{
	static function valueType($value): string {
		$type = gettype($value);
		switch($type) {
			case 'boolean':
			case 'integer':
				return 'i';
			case 'double':
				return 'd';
			case 'string':
			case 'NULL':
				return 's';
			default:
				throw new Error("No se pueden insertar '{$type}' en mysql");
		}
	}
}
