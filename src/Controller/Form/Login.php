<?php namespace Controller\Form;

use Controller\Component\Navbar;
use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class Login extends Form {

	function __construct() {
		parent::__construct('login.phtml');
		$this->title('Iniciar sesión');
		$this->style('css/login.css');
		$this->header[] = new Navbar;
	}

	function _submit(): ?string {
		Session::create($this->user);
		return 'Sesion iniciada';
	}

	function verify() {
		if(!Form::check($_POST, [
			'email' => '[!?#]string|',
			'password' => '[!?#]string|',
		])) $this->error('Formulario invalido');

		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(User::TABLE);
		$select->condition('email', $_POST['email']);
		$select->execute();
		$this->user = $select->fetch(User::class);
		if(empty($this->user))
			$this->error('Verifique los datos');
		if(!password_verify($_POST['password'], $this->user->password))
			$this->error('Verifique los datos');
	}
}
