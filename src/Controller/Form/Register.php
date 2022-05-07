<?php namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\User;

class Register extends Form {
    function __construct()
    {
        parent::__construct('register.phtml');
        $this->addStyle('css/register.css');
        $this->setTitle('Registro');
    }
    public function verify(): bool
    {
        if(!isset($_POST['correo']) || empty($_POST['correo']))
        if(!isset($_POST['nombre']) || empty($_POST['nombre']))
        if(!isset($_POST['contraseña']) || empty($_POST['contraseña']))
        if(!isset($_POST['contraseña2']) || empty($_POST['contraseña2']))
        return false;   
    return true;
    }
    
    public function _submit()
    {
    $html = new User("register");
    $mail = $_POST['correo'] ?? null;
    $name = $_POST['nombre'] ?? null;
    $password = $_POST['contraseña'] ?? null;
    $password2 = $_POST['contraseña2'] ?? null;

    $user = new User();
    $incrip = password_hash($password, PASSWORD_DEFAULT);
    $user->email=$mail;
    $user->username=$name;
    $user->password=$incrip;
    $user->role="user";

    if ($password!=$password2) {
        $this->addMessage("Las contraseñas ingresadas no son iguales");
        return $html;
    }

    $user->save();
    $this->addMessage("Se ha registrado exitosamente!");;
    }
}