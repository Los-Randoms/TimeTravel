<?php namespace Controller\Form;

use Modules\Account\User as AccountUser;
use Modules\Kernel\Form;
use Modules\Kernel\User;
use Modules\Kernel\Storage;


class Login extends Form {
	function __construct() {
		parent::__construct('login.phtml');
		$this->Title('Iniciar sesión');
	}

	function _submit() {
		/** @var User */
        /** @var \Module\Mysql\Driver */
        $driver=Storage::driver();
        $select=$driver->read(AccountUser::TABLE);
        $select->condition('email', $_POST['correo']);
        $user=$select->execute();

		if(empty($user))
			return /*$this->addMessage("Verifique sus credenciales")*/;
			if(!password_verify($_POST['password'], $user->password))
			return /*$this->addMessage("Verifique sus credenciales")*/;
		session_start();
		$_SESSION['uid'] = $user->id;
		header('Location: /');
		die;
	}

	function verify(): bool {
		if(!isset($_POST['email']) || empty($_POST['email'])) {
			//$this->addMessage('Rellene los campos correctamente');
			return false;
		}

		if(!isset($_POST['password']) || empty($_POST['password'])) {
			//$this->addMessage('Rellene los campos correctamente');
			return false;
		}

		return true;
	}
}
