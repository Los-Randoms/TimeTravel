<?php

namespace Controller\Form;

use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;
use Modules\Router\Router;

class Login extends Form
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
			'password' => [
				'trim' => true,
				'from' => &$_POST,
			],
		]);
		$this->styles[] = 'login.css';
		$this->db = Storage::driver();
	}

	function title(): string
	{
		return 'Iniciar sesión';
	}

	function verify(&$data)
	{
		$query = $this->db->read(User::TABLE);
		$query->condition('banned', false, 'i');
		$query->condition('email', $data['email']);
		$query->execute();
		$this->user = $query->fetch(User::class);
		if (empty($this->user))
			return Message::add('Verifique los datos');
		if (!password_verify($data['password'], $this->user->password))
			return Message::add('Verifique los datos');
		return true;
	}

	function submit(&$data)
	{
		Session::login($this->user);
		Session::save();
		Message::add('Sesión iniciada');
		return Router::get('/');
	}

	function content()
	{
		return new View('page/login.phtml');
	}
}
