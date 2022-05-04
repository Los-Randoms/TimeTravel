<?php
require_once "src/autoloader.php";

use Modules\Kernel\Enviroment;
use Modules\Kernel\NotFoundException;
use Modules\Kernel\Page;
use Modules\Kernel\Router;

ini_set('upload_tmp_dir', 'tmp/files');
ini_set('session.use_strict_mode', true);
session_save_path('tmp/sessions');
session_name('_SSID');
Enviroment::read('site.ini');
Enviroment::include('local.ini');
Router::read('routes.json');

try {
	$request_url = parse_url($_SERVER['REQUEST_URI']);
	/** @var Page */
	$content = Router::get($request_url['path']);
	if(empty($content))
		throw new NotFoundException('Page not found');
	$event = $content->init();
	if($event) $event->invoke($content);
	$content->render();
} catch(NotFoundException $not_found) {
	$view = new $_ENV['Site']['not_found'];
	$view->error = $not_found;
	// View::render($view->getPage());
} catch(Error|Exception $error) {
	$view = new $_ENV['Site']['error_page'];
	$view->error = $error;
	// View::render($view->getPage());
}
