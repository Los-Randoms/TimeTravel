<?php

require_once 'src/autoloader.php';
require_once 'settings.php';
include_once 'local.settings.php';

use Modules\Account\Session;
use Modules\Kernel\ErrorPage;
use Modules\Kernel\View;
use Modules\Router\Route;
use Modules\Router\Router;

Router::file('routes.json');
Session::init();

$page = new View('page.phtml');
try {
	$controller = Router::current();
	$response = $controller->init() ?? $controller->content();
	# Response handling
	if (is_object($response) && $response instanceof View) { # The response is a view
		header('Content-Type: text/html; charset=utf-8');
		$page->set('title', $controller->title());
		$page->set('content', $response);
		echo $page;
	} else if (is_object($response) && $response instanceof Route) { # The response is a redirect
		header("Location: {$response->getPath()}");
	} else if (is_object($response) || is_array($response)) { # The response is a json
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($response);
	} else {
		header('Content-Type: text/plain; charset=utf-8');
		echo $response;
	}
} catch (Error | Exception $error) {
	$controller = new ErrorPage($error);
	$page->set('title', $controller->title());
	$page->set('content', $controller->content());
	echo $page;
}

Session::stop();

