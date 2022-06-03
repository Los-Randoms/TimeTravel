<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Router;

class Register extends Form
{
	function __construct()
	{
		$this->styles[] = 'register.css';
	}

	function title(): string
	{
		return 'Registro';
	}

	function content()
	{
		return new View('page/register.phtml');
	}

	function verify(): bool
	{
		$this->file = FileManager::get('avatar');
		if (!is_null($this->file)) {
			FileManager::move($this->file, 'avatars');
			$this->file->save();
		}
		return true;
	}

	function submit()
	{
		$user = new User();
		$user->email = $_POST['email'];
		$user->username = $_POST['username'];
		$user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);

		if (!is_null($this->file)) {
			$this->currentUser->avatar = $this->file->id;
		}

		$user->save();
		Message::add('¡Se ha registrado correctamente!');
		return Router::get('/iniciar-sesion');
	}
}
