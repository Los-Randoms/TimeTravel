<?php

namespace Controller\Form;

use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class Login extends Form
{

	function __construct()
	{
		// $this->style('css/login.css');
		// $this->header[] = new Navbar;
	}

	function title(): string
	{
		return 'Iniciar sesión';
	}

	function verify(): bool
	{
		# if (!Form::check($_POST, [
		# 	'email' => '[!?#]string|',
		# 	'password' => '[!?#]string|',
		# ])) $this->error('Formulario invalido');

		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(User::TABLE);
		$select->condition('email', $_POST['email']);
		$select->execute();
		$this->user = $select->fetch(User::class);
		if (empty($this->user))
			return $this->error('Verifique los datos');
		if (!password_verify($_POST['password'], $this->user->password))
			return $this->error('Verifique los datos');
		return true;
	}

	function submit()
	{
		Session::login($this->user);
		Message::add('Sesion iniciada');
	}

	function content()
	{
		return new View('page/login.phtml');
	}
}
