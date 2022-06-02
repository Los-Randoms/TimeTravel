<?php

namespace Modules\Kernel;

use StringBackedEnum;

enum MessageTypes: string
{
	case Info = "info";
	case Warn = "warn";
	case Pass = "pass";
	case Fail = "fail";
}

final class Message extends View
{
	public function __construct(string $message, MessageTypes $type)
	{
		parent::__construct('message.phtml', [
			'message' => $message,
			'type' => $type->value,
		]);
	}

	# Statig messages functions
	static function add(string $message, MessageTypes $type = MessageTypes::Info)
	{
		$_SESSION['messages'][] = new Message($message, $type);
	}

	static function get(): ?Message {
		return array_pop($_SESSION['messages']);
	}
}
