<?php namespace Controller\Form;

use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class Login extends Form {
	private User $user;

	function __construct() {
		parent::__construct('login.phtml');
		$this->title('Iniciar sesión');
	}

	function _submit() {
		if(empty($this->user))
			return $this->error('Verifique sus credenciales');
		if(!password_verify($_POST['password'], $this->user->password))
			return $this->error('Verifique sus credenciales');
		Session::create($this->user);
		header('Location: /');
		die;
	}

	function verify(): bool {
		if(!isset($_POST['email']) || empty($_POST['email']))
			return $this->error('Rellene los campos correctamente');
		if(!isset($_POST['password']) || empty($_POST['password']))
			return $this->error('Rellene los campos correctamente');

		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(User::TABLE);
		$select->condition('email', $_POST['email']);
		$this->user = $select->execute()->row(User::class);
		if(empty($this->user))
			return $this->error('Verifique los datos');
		if(!password_verify($this->user->password, $_POST['password']))
			return $this->error('Verifique los datos');
		return true;
	}
}
