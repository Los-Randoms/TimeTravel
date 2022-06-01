<?php namespace Controller\Page;

use Modules\Kernel\Controller;
use Modules\Kernel\Message;
use Modules\Kernel\View;

class Main extends Controller {
	function __construct() {
	}

	function content() {
		Message::add('Test message');
		Message::add('123tamarindo - jsisodaksd');
		Message::add('Test message');
		return new View('page/index.phtml');
	}
}
