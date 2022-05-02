<?php namespace Controller\Page;

use Modules\Kernel\Form;
use Modules\Kernel\User;


class CP extends Form {
    function __construct()
    {
        parent::__construct('change-pass.phtml');
        $this->addStyle('css/cp.css');
        $this->setTitle('Cambiar contraseña');
    }

    public function verify(): bool
    {
        echo 'Confirmando...';
        if(!isset($_POST['correo']) || empty($_POST['correo']))
            return false;   
        return true;
    }

    public function _submit()
    {
       $user = User::search(
          ['email = ', $_POST['correo']]
       )[0];
       
       
       
       $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz$#';
       $correo = $_POST["correo"];
       $newp=substr(str_shuffle($permitted_chars), 0, 8); //genera carcteres aleatorio
       //fetch_object es para que los resultados de la busqueda se guarden como un objeto, y para poder buscar un objeto 
       //se puede poner print_r($res->"Lo que sea que estes buscando");
       $user->password=$newp;
       $incrip = password_hash($user->password, PASSWORD_DEFAULT); //encriptado de contraseña
       $user->password=$incrip;
       $user->update();
       
       //mail($correo, 
       //'Cambio de contraseña',  
       //"Hemos recibido su solicitud de cambio de contraseña y su nueva contraseña es: $newp");
       echo 'Se ha enviado a su correo una nueva contraseña temporal';
    }
}