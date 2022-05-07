<?php namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\User;

class Login extends Form {
	function __construct() {
		parent::__construct('login.phtml');
		$this->setTitle('Iniciar sesión');
		//$this->addMessage('Prueba');
		//$this->addMessage('Prueba');
		//$this->addMessage('Prueba');
	}

	function _submit() {
		# echo 'Ok!';
		$user = User::search(['email=', $_POST['email']]);
		if(empty($user))
			return $this->addMessage("Verifique el correo");
	}

	function verify(): bool {
		# echo 'Verificando...';
		if(!isset($_POST['email']) || empty($_POST['email']))
			return false;
		if(!isset($_POST['password']) || empty($_POST['password']))
			return false;
		return true;
	}
}
