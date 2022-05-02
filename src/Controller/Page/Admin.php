<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Admin extends Page {
	function __construct() {
		parent::__construct('admin_archive.phtml');
		$this->setTitle('Pagina del admon');
		$this->addStyle('css/adminstyle.css');
	}
}
