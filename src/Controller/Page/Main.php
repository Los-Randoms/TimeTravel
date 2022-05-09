<?php namespace Controller\Page;

use Modules\Kernel\Page;
use Modules\Kernel\View;

class Main extends Page {
	public array $publicaciones;

	function __construct() {
		parent::__construct('index.phtml');
		$this->style('css/index.css');
		$this->header[] = new View('component/banner.phtml');
	}
}
