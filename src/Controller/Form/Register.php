<?php namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;

class Register extends Form {
    function __construct() {
        parent::__construct('register.phtml');
        $this->style('css/register.css');
        $this->title('Registro');
	}

    public function verify(): bool {
        if(!isset($_POST['correo']) || empty($_POST['correo']))
			return false;   
        if(!isset($_POST['nombre']) || empty($_POST['nombre']))
			return false;   
        if(!isset($_POST['contraseña']) || empty($_POST['contraseña']))
			return false;   
		return true;
    }
    public function _submit() {
	#	$incrip = password_hash($password, PASSWORD_DEFAULT);
	#	$user->email=$mail;
	#	$user->username=$name;
	#	$user->password=$incrip;
	#	$user->role="user";
    #
	#	if ($password!=$password2) {
	#		$this->addMessage("Las contraseñas ingresadas no son iguales");
	#		return $html;
	#	}
    #
	#	$user->save();
	#	$this->addMessage("Se ha registrado exitosamente!");;
    }
}
