<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Admin extends Page {
	function __construct() {
		parent::__construct('admin_archive.phtml');
		$this->setTitle('Página del admin');
		$this->addStyle('css/adminstyle.css');
	}
}
