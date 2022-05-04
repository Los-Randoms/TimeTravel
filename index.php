<?php
require_once "src/autoloader.php";
require_once 'settings.php';
include_once 'local.settings.php';

session_start();
use Modules\Router\Router;
Router::file('routes.json');

$content = Router::current();
$content->render();

# try {
# 	/** @var Page */
# 	$event = $content->init();
# 	if($event) $event->invoke($content);
# 	$content->render();
# } catch(Error|Exception $error) {
# 	/** @var Page */
# 	# $view->error = $error;
# 	# $view->render();
# }
