<?php namespace Controller\Page;

use Entity\Publication;
use Modules\Kernel\Page;

class Main extends Page {
	public array $publicaciones;
	function __construct() {
		parent::__construct('index.phtml');
		$this->setTitle('Time travel');
		$this->addStyle('css/index.css');
		$this->addStyle('css/publication.css');
		$this->publicaciones = $this->publicaciones = Publication::search([]);
		print_r($this->publicaciones);
	}
}
