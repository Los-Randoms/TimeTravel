<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Demo extends Page {
	public array $publications;

	function __construct() {
		parent::__construct('demo.phtml');
		$this->style('css/index.css');
	}
}
