<?php

require_once 'src/autoloader.php';
require_once 'settings.php';
include_once 'local.settings.php';

use Modules\Account\Session;
use Modules\Kernel\ErrorPage;
use Modules\Kernel\View;
use Modules\Router\Router;

Router::file('routes.json');
Session::init();

$page = new View('page.phtml');
try {
	$controller = Router::current();
	$controller->init();
	$response = $controller->content();
	# Response handling
	if(is_object($response) && $response instanceof View) {
		$page->set('title', $controller->title());
		$page->set('content', $response);
		echo $page;
	} else if(is_object($response) && $content) {
	}
} catch(Error|Exception $error) {
	$controller = new ErrorPage($error);
	$page->set('title', $controller->title());
	$page->set('content', $controller->content());
	echo $page;
}

