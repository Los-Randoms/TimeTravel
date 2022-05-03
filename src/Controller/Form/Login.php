<?php namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\User;

class Login extends Form {
	function __construct() {
		parent::__construct('login.phtml');
		$this->setTitle('Iniciar sesión');
	}

	function _submit() {
		/** @var User */
		$user = User::search(['email=', $_POST['email']])[0];
		if(empty($user))
			return $this->addMessage("Verifique sus credenciales");
		if(!password_verify($_POST['password'], $user->password))
			return $this->addMessage("Verifique sus credenciales");
		session_start();
		$_SESSION['uid'] = $user->id;
		header('Location: /');
		die;
	}

	function verify(): bool {
		if(!isset($_POST['email']) || empty($_POST['email'])) {
			$this->addMessage('Rellene los campos correctamente');
			return false;
		}

		if(!isset($_POST['password']) || empty($_POST['password'])) {
			$this->addMessage('Rellene los campos correctamente');
			return false;
		}

		return true;
	}
}
