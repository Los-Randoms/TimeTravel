<?php namespace Modules\Kernel;

use Modules\Account\Session;

class Response {
	static function send(string $response) {
		while(ob_get_level() > 0)
			ob_end_clean();
		echo $response;
		Session::stop();
		if(Storage::connected())
			Storage::driver()->close();
		die;
	}

	static function json(object|array $data) {
		header('Content-Type: application/json; charset=utf-8');
		self::send(json_encode($data));
	}

	static function text(string $data) {
		header('Content-Type: text/plain; charset=utf-8');
		self::send($data);
	}

	static function html(string $html) {
		header('Content-Type: text/html; charset=utf-8');
		self::send($html);
	}
}
