<?php namespace Modules\Messenger;

abstract class Messages {
    static private array $messages = [];

    static function add(string $message, string $type) {
        self::$messages[] = [
            'message' => $message,
            'type' => $type,
        ];
	}

	static function next(): null|array {
		$ret = current(self::$messages);
		next(self::$messages);
		if(empty($ret));
			return null;
		return $ret;
	}

}
