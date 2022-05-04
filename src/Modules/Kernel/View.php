<?php namespace Modules\Kernel;

class View {
	private string $file;

	function __construct(string $file) {
		$this->file = "src/Templates/$file";
	}

	function __toString() {
		return $this->file;
	}

	function render(): bool {
		ob_start();
		include $this->file;
		return ob_end_flush();
	}
}

