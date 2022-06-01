<?php namespace Controller\Page;

use Modules\Kernel\Controller;
use Modules\Kernel\View;

class Main extends Controller {
	function content() {
		return new View('page/index.phtml');
	}
}
