<?php namespace Modules\Kernel;

use ReflectionMethod;

abstract class Form extends Page {
	function init(): ?ReflectionMethod {
		$event = parent::init();
		if(empty($event))
			return null;
		if($event->getName() === '_submit') {
			if($this->verify()) {
				$message = $this->_submit();
				Response::json([
					'type' => 'success',
					'message' => $message,
				]);
			} else {
				Response::json([ 'type' => 'error' ]);
			}
		}
		return $event;
	}

	protected function error(string $message) {
		Response::json([
			'type' => 'error',
			'message' => $message,
		]);
	}

	// format: [?!#]string|30
	static function check(array &$arr, array $conditions): bool {
		foreach($conditions as $key => $condition) {
			$_isset = false;
			$_empty = false;
			$_trim = false;
			$type = null;
			$len = null;
			$match = preg_match(
				'/^\[(.*)\](.*)\|(\d*)$/', 
				$condition, $results, 
				PREG_OFFSET_CAPTURE
			);
			if($match) {
				$flags =& $results[1][0];
				for($i = 0; $i < strlen($flags); $i++) {
					$c = $flags[$i];
					switch($c) {
						case '!': $_isset = true; break;
						case '?': $_empty = true; break;
						case '#': $_trim = true; break;
					}
				}
				if(!empty($results[2][0]))
					$type = $results[2][0];
				if(!empty($results[3][0]))
					$len = intval($results[3][0]);
			}
			if($_isset && !isset($arr[$key])) 
				return false;
			if($_trim) $arr[$key] = trim($arr[$key]);
			if($_empty && empty($arr[$key])) 
				return false;
			if(!empty($type))
				settype($arr[$key], $type);
			if(!empty($len) && (strlen($arr[$key]) < $len))
				return false;
		}
		return true;
	}

	abstract function verify();
	abstract function _submit(): ?string;
}
