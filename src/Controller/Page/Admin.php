<?php

namespace Controller\Page;

use Modules\Kernel\Controller;
use Modules\Kernel\View;

class Admin extends Controller
{
	function __construct()
	{
		$this->access('admin');
		$this->styles[] = 'admin.css';
	}

	function title(): string {
		return 'Administracion';
	}

	function content() {
		return new View('page/admin.phtml');
	}
}
