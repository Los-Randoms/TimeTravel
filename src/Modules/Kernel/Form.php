<?php namespace Modules\Kernel;

use Modules\Messenger\Messages;
use ReflectionMethod;

abstract class Form extends Page {
	function init(): ?ReflectionMethod {
		$event = parent::init();
		if(empty($event))
			return null;
		if(!$this->verify())
			return null;
		return $event;
	}

	protected function error(string $message, string $field = null): bool {
		Messages::add($message, 'error');
		return false;
	}

	// format: [?!#]string|30
	static function verifyFields(array $fields, array $conditions) {
		foreach($conditions as $key => $condition) {
			$data = preg_match('/^\[(.*)\](.*)\|(\d*)$/', $condition, $results, PREG_OFFSET_CAPTURE);
			print_r($data);
			print_r($results);
		}
	}
	
	abstract function verify(): bool;
	abstract function _submit();
}
