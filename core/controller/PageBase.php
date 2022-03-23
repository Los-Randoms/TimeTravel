<?php namespace Core\controller;

use Core\Request;

abstract class PageBase {
	function redirect(string $url) {
		header("Location: $url", true, 303);
		http_response_code(303);
		die;
	}

	function request(): Request {
		return Request::current();
	}
}

