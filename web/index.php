<?php
# Load the autoloader and site settings
require_once '../src/autoloader.php';
require_once '../settings.php';
include_once '../local.settings.php';

use Modules\Account\Session;
use Modules\Kernel\ErrorPage;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Route;
use Modules\Router\Router;

# Load site routes and messages
Router::file('../routes.json');
Message::init();
Session::init();

# Default headers
header('Content-Type: text/html; charset=utf-8');

# Default routing
try {
	$contr = Router::current();
	$response = $contr->init() ?? $contr->content();
	if (isset($response)) {
		if($response instanceof View) {
			$page = new View('page.phtml');
			$page->set('title', $contr->title()); 
			$page->set('styles', $contr->styles ?? []); 
			$page->set('scripts', $contr->scripts ?? []); 
			$page->set('content', $response); 
			echo $page;
		} elseif ($response instanceof Route)
			header("Location: {$response->getPath()}");
		else
			echo $response;
	}
}
# Catch error and show the error page
catch (Error | Exception $error) {
	# Clean the buffer
	while (ob_get_level() > 0)
		ob_end_clean();
	# Create the page
	$page = new View('page.phtml', []);
	$contr = new ErrorPage($error);
	$page->set('title', $contr->title());
	$page->set('content', $contr->content());
	echo $page;
}

