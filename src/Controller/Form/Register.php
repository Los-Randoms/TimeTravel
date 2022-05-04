<?php namespace Controller\Form;

use Modules\Kernel\Form;

class Register extends Form {
	function __construct() {
		parent::__construct('register.phtml');
	}

	function verify(): bool {
	}

	function _submit() {
		
	}
}
