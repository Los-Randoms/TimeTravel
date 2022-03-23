<?php namespace Core;

class Request {
	static private $current_request;
	private string $uri;
	private array $params;
	private array $headers;

	public static function current(): self {
		if(!isset(self::$current_request)) {
			$request = new self($_SERVER['REQUEST_URI']);
			$headers = apache_request_headers();
			foreach($_GET as $key => $value)
				$request->setParam($key, $value);
			foreach($headers as $key => $value)
				$request->setHeader($key, $value);
			self::$current_request = $request;
		}
		return self::$current_request; 
	}

	public function __construct(string $uri) {
		$this->uri = $uri;
	}

	public function getParam(string $key) {
		return $this->params[$key] ?? null;
	}

	public function setParam(string $key, $value) {
		$this->params[$key] = $value;
	}

	public function setHeader(string $key, $value) {
		$this->headers[$key] = $value;
	}

	public function getHeader(string $key) {
		return $this->headers[$key] ?? null;
	}

	public function getPath(): string {
		return parse_url($this->uri, PHP_URL_PATH);
	}

	public function getScheme(): string {
		return parse_url($this->uri, PHP_URL_SCHEME);
	}

	public function getHost(): string {
		return parse_url($this->uri, PHP_URL_HOST);
	}

	public function getPort(): string {
		return parse_url($this->uri, PHP_URL_PORT);
	}
}
