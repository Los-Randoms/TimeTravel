<?php

namespace Modules\Kernel;

use Exception;
use Modules\Account\User;

abstract class Controller
{
	private array $access;

	function init() {
		# Check if the user has permissions
		if(isset($this->access)) {
			if(!$_SESSION['account']['logged'])
				throw new Exception('', 403);
			if(!empty($this->access)) {
				/** @var User */
				$user = $_SESSION['account']['user'];
				if(!in_array($user->rol, $this->access))
					throw new Exception('', 403);
			}
		}
	}

	final protected function access(string ...$roles) {
		$this->access = $roles;
	}

	function title(): string {
		return SITE_NAME;
	}

	abstract function content();
}
