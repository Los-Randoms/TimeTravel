<?php namespace Core\phtml;

class Template {
	private string $file;
	private ?array $data;

	public function __construct(string $file, ?array $data = []) {
		$this->file = $file;
		$this->data = $data;
	}

	public function render(bool $return = false): string|bool {
		$_self = &$this->data;
		ob_start();
		include "$_SERVER[SITE_DIR]/templates/{$this->file}.phtml";
		return $return? ob_get_clean() : ob_end_flush();
	}

	public function get(string $key) {
		return $this->data[$key] ?? null;
	}

	public function set(string $key, $value) {
		$this->data[$key] = $value;
	}

	static public function renderFile(string $file, ?array $data = []) {
		$template = new self($file, $data);
		$template->render();
	}
}
