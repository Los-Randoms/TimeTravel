<?php

namespace Modules\Kernel;

use Modules\Router\Router;

class App
{
	private View $page;

	function __construct()
	{
		$this->page = new View('page.phtml');
		$this->page->content = Router::current();
	}

	function init()
	{
		echo $this->page;
	}
}
#Session::start();
#header('Content-Type: text/html; charset=utf-8');
#
#try {
#	$page = Router::current();
#	$fn = $page->init();
#	if(!empty($fn))
#		$fn->invoke($page);
#	$page->render();
#} catch(Error|Exception $e) {
#	while(ob_get_level() > 0)
#		ob_end_clean();
#	$page = new ErrorPage($e);
#	$page->render();
#}
#
#Session::stop();
#Storage::stop();
