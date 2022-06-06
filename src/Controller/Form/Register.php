<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;
use Modules\Router\Router;

class Register extends Form
{
	protected Driver $db;

	function __construct()
	{
		parent::__construct('POST', [
			'email' => [
				'trim' => true,
				'from' => &$_POST,
				'filter' => [
					'type' => FILTER_VALIDATE_EMAIL
				],
			],
			'password_1' => [
				'from' => &$_POST,
				'length' => 7,
			],
			'password_2' => [
				'from' => &$_POST,
				'length' => 7,
			],
			'username' => [
				'trim' => true,
				'from' => &$_POST,
			],
		]);
		$this->styles[] = 'register.css';
		$this->db = Storage::driver();
	}

	function title(): string
	{
		return 'Registro';
	}

	function content()
	{
		return new View('page/register.phtml');
	}

	function verify(&$data)
	{
		$query = $this->db->read(User::TABLE);
		$query->condition('email', $data['email']);
		$query->execute();
		if(!empty($query->fetch()))
			return Message::add('El usuario ya esta registrado');
		if($data['password_1'] !== $data['password_2'])
			return Message::add('Las contraseñas no coinciden');
		return true;
	}

	function submit(&$data)
	{
		$user = new User();
		$user->email = $data['email'];
		$user->username = $data['username'];
		$user->password = password_hash($data['password_1'], PASSWORD_BCRYPT);
		$user->save();
		Message::add('¡Se ha registrado correctamente!');
		return Router::get('/iniciar-sesion');
	}
}
