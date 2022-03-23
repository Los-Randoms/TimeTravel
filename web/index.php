<?php namespace Core;
require_once "autoload.php";
use Core\phtml\Template;
use Error;

$_ENV += parse_ini_file("$_SERVER[SITE_DIR]/.env", true);
$_ENV += parse_ini_file("$_SERVER[SITE_DIR]/.local.env", true);

# Handle the request path and user the controller
$request = Request::current();
$route = Router::instance()->get($request->getPath());
try {
	$page = new Template('page.template');
	if($route) {
		$controller = new $route['controller']['class']();
		$template = $controller->{$route['controller']['function']}();
		$page->set('title', $route['title'] ?? $controller->title ?? $_ENV['site']['name']);
		$page->set('content', $template);
	} else {
		$not_found = new Template('error/not_found');
		$page->set('title', 'Page not found');
		$page->set('content', $not_found);
	}
	$page->render();
} catch(Error $e) {
	while(ob_get_level() != 0)
		ob_end_clean();
	$error = new Template('error/internal');
	$error->set('exception', $e);
	$page = new Template('page.template');
	$page->set('title', 'Server error :(');
	$page->set('content', $error);
	$page->render();
}
