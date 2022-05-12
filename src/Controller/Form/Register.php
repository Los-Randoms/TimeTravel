<?php namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
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
		$this->file=File::getUploadedFile('avatar');
		$this->file->moveTo('avatars');
		$this->file->save();
	}
	
	function _submit(): ?string {
		$mail=$_POST['email'];
		$name=$_POST['username'];
		$user = new User();
		$incrip = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$user->email=$mail;
		$user->username=$name;
		$user->password=$incrip;
		$user->rol="user";
		$user->avatar=$this->file->id;
		$user->save();
		return 'Se ha registrado exitosamente!';
	}
}
