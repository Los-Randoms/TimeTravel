<?php

namespace Controller\Page;

use Modules\Kernel\Controller;
use Modules\Kernel\View;

class Admin extends Controller
{
	function __construct()
	{
		$this->styles[] = 'admin.css';
		$this->access('admin');
	}

	function title(): string {
		return 'Página del admin';
	}

	function content() {
		return new View('page/admin.phtml');
	}
}
