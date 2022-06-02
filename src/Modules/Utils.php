<?php

namespace Modules;

use DateTime;

final class Utils {
	static function date(string $date): string {
		$date = new DateTime($date);
		return strftime('%d de %B del %G', $date->getTimestamp());
	}
}

