<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Main extends Page {
	public array $publicaciones;

	function __construct() {
		parent::__construct('index.phtml');
		// $this->setTitle($_ENV['Site']['name']);
		// $this->addStyle('css/index.css');
		// $this->addStyle('css/publication.css');
		// $this->publicaciones = Publication::search([]);
	}
}
