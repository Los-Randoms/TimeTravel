<?php namespace Modules\Kernel;


class View {
	private string $file;
	private array $data;

	function __construct(string $file, array $data = []) {
		$this->file = "../src/Views/$file";
		$this->data = $data;
	}

	function set(string $key, $value) {
		$this->data[$key] = $value;
	}

	function path(): string {
		return $this->file;
	}

	function __toString(): string {
		extract($this->data);
		ob_start();
		include $this->file;
		return ob_get_clean();
	}
}

