<?php

namespace Controller\Page;

use Modules\Kernel\Controller;
use Modules\Kernel\Message;
use Modules\Kernel\MessageTypes;
use Modules\Kernel\View;

class Main extends Controller
{
	function __construct()
	{
		$this->styles[] = 'index.css';
	}

	function content()
	{
		return new View('page/index.phtml');
	}
}
