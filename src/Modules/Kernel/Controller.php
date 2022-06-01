<?php

namespace Modules\Kernel;

abstract class Controller
{
	private array $access = [];

	final function init() {
	}

	function title(): string {
		return SITE_NAME;
	}
	abstract function content();
}
