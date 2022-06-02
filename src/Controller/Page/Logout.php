<?php

namespace Controller\Page;

use Modules\Account\Session;
use Modules\Kernel\Controller;
use Modules\Router\Router;

class Logout extends Controller
{
	function content()
	{
		Session::logout();
		return Router::get('/');
	}
}
