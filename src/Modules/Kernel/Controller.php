<?php

namespace Modules\Kernel;

use Exception;
use Modules\Account\Session;

abstract class Controller
{
	/**
	 * The access nedded for this page
	 * @var array
	 * */
	private array $access;

	/**
	 * Set the access needded fo this page
	 * @param string ...$roles
	 * */
	protected function access(string ...$roles)
	{
		$this->access = $roles;
	}

	/**
	 * Init the controller and if
	 * the current user has permissions
	 * */
	function init()
	{
		# Check if the user has permissions
		if (isset($this->access)) {
			if (!Session::logged())
				throw new Exception('Permiso denegado', 403);
			if (!empty($this->access)) {
				if (!in_array($_SESSION['user']->rol, $this->access))
					throw new Exception('Permiso denegado', 403);
			}
		}
	}

	/**
	 * Retutn the site title
	 * the default title is the site name
	 * @return string
	 * */
	function title(): string
	{
		return SITE_NAME;
	}

	/**
	 * Controller content function
	 * @return mixed $response
	 * */
	abstract function content();
}
