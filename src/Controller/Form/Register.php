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
        if(!isset($_POST['email']) || empty($_POST['email']))
			return false;   
        if(!isset($_POST['username']) || empty($_POST['username']))
			return false;   
        if(!isset($_POST['password']) || empty($_POST['password']))
			return false;   
		if(!isset($_POST['password2']) || empty($_POST['password2']))
			return false;   	
		return true;
    }
    public function _submit() {

		$password=$_POST['password'];
		$password2=$_POST['password2'];
		$mail=$_POST['email'];
		$name=$_POST['username'];
		
		$user = new User();
		$incrip = password_hash($password, PASSWORD_DEFAULT);
		$user->email=$mail;
		$user->username=$name;
		$user->password=$incrip;
		$user->role="user";
    
		if ($password!=$password2) {
			$this->error("Las contraseñas ingresadas no son iguales");
			return ;
		}
    
		$user->save();
		$this->error("Se ha registrado exitosamente!");;
    }
}
