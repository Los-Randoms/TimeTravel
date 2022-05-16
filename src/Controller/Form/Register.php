<?php namespace Controller\Form;

use Controller\Component\Navbar;
use Modules\Account\User;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;

class Register extends Form {
    function __construct() {
        parent::__construct('register.phtml');
        $this->style('css/register.css');
		$this->title('Registro');
	}

    public function verify() {
		if(!Form::check($_POST, [
			'email' => '[!?#]string|',
			'username' => '[!?#]string|',
			'password' => '[!?#]string|8',
			'password2' => '[!?#]string|8',
		])) $this->error('Formulario invalido');
		if ($_POST['password']!=$_POST['password2']) {
			$this->error("Las contraseñas ingresadas no son iguales");
		}
	}
	
	function _submit(): ?string {
		$mail=$_POST['email'];
		$name=$_POST['username'];
		$user = new User();
		$user->email=$mail;
		$user->username=$name;
		$user->password=password_hash($_POST['password'], PASSWORD_DEFAULT);;
		$user->rol="user";
		$user->save();
		return 'Se ha registrado exitosamente!';
	}
}
