<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;

class Register extends Form
{
	function __construct()
	{
		$this->styles[] = 'register.css';
	}

	function title(): string {
		return 'Registro';
	}

	function content() {
		return new View('page/register.phtml');
	}

	function verify(): bool
	{
		return true;
	}

	function submit()
	{
		$user = new User();
		$user->email = $_POST['email'];
		$user->username = $_POST['username'];
		$user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$user->save();
		Message::add('¡Se ha registrado correctamente!');
	}
}
