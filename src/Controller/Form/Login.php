<?php

namespace Controller\Form;

use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Utils;
use Modules\Router\Router;

class Login extends Form
{
	protected ?User $user;

	function __construct()
	{
		$this->styles[] = 'login.css';
	}

	function title(): string
	{
		return 'Iniciar sesión';
	}

	function verify(): bool
	{
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$query = $driver->read(User::TABLE);
		$query->condition('banned', false, 'i');
		$query->condition('email', $_POST['email']);
		$query->execute();
		$this->user = $query->fetch(User::class);

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
		return Router::get('/');
	}

	function content()
	{
		return new View('page/login.phtml');
	}
}
