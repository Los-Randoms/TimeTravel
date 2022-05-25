<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Contacto extends Page {
	function __construct() {
		parent::__construct('contacto.phtml');
		$this->title('Pagina de contacto');
		$this->style('css/contacto.css');

	}
}
