<?php

namespace Modules\Kernel;

abstract class Form extends Controller
{
	function init()
	{
		parent::init();
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		if ($method === 'POST') {
			if ($this->verify())
				return $this->submit();
		}
	}

	function error(string $message): bool 
	{
		Message::add($message, MessageTypes::Fail);
		return false;
	}

	abstract function verify(): bool;
	abstract function submit();
}
