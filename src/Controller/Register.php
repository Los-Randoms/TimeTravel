<?php namespace TimeTravel\Controller;

use Core\controller\PageBase;
use Core\mysql\Database;
use Core\phtml\Template;
use Core\session\User;

class Register extends PageBase
//ruta de controlador de register
{
    function regis ()
    {
        $html = new Template("register");

        if(isset($_GET['submit'])) {
            $mail = $_POST['correo'] ?? null;
            $name = $_POST['nombre'] ?? null;
            $password = $_POST['contraseña'] ?? null;
            $password2 = $_POST['contraseña2'] ?? null;

            $user = new User();
            $incrip = password_hash($password, PASSWORD_DEFAULT);
            $user->email=$mail;
            $user->username=$name;
            $user->password=$incrip;

            if ($password!=$password2) {
                $html->set('mensaje', "La contraseña no es igual") ;
                return $html;
            }

            $db = Database::instance();
            $tabla = $db->storage(User::class);
            $tabla->save($user);
            $html->set('mensaje', "Se ha registrado exitosamente") ;
        }
        return $html;
    }
}