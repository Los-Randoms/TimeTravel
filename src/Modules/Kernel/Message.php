<?php

namespace Modules\Kernel;

enum MessageTypes: string
{
	case Info = "info";
	case Warn = "warn";
	case Pass = "pass";
	case Fail = "fail";
}

final class Message extends View
{
	/**
	 * Initialize messages
	 * */
	static function init() {
		$messages = $_COOKIE['messages'] ?? null;
		if(!empty($_COOKIE['messages']))
			$_COOKIE['messages'] = unserialize($messages);
		else
			$_COOKIE['messages'] = [];
		setcookie('messages', serialize([]), null, '/');
	}

	/**
	 * Add a messages
	 * */
	static function add(string $message, MessageTypes $type = MessageTypes::Info)
	{
		$_COOKIE['messages'][] = [
			'message' => $message, 
			'type' => $type->value,
		];
		setcookie('messages', serialize($_COOKIE['messages']), null, '/');
	}

	/**
	 * Get the mesages of the user
	 * */
	static function get(): ?View {
		$alert = array_pop($_COOKIE['messages']);
		if(isset($alert)) {
			return new View('message.phtml', [
				'message' => $alert['message'],
				'type' => $alert['type'],
			]);
		}
		return null;
	}
}
