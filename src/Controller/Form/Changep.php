<?php namespace Controller\Form;

use Modules\Kernel\Form;

class Changep extends Form {
    function __construct() {
        parent::__construct('changep.phtml');
        $this->style('css/changep.css');
        $this->title('Cambiar contraseña');
    }

    public function verify(): bool {
        if(!isset($_POST['correo']) || empty($_POST['correo']))
            return false;   
        return true;
    }

    public function _submit() {
       $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz$#';
       $correo = $_POST["correo"];
       $newp=substr(str_shuffle($permitted_chars), 0, 8); //genera carcteres aleatorio
       //fetch_object es para que los resultados de la busqueda se guarden como un objeto, y para poder buscar un objeto 
       //se puede poner print_r($res->"Lo que sea que estes buscando");
       $user->password=$newp;
       $incrip = password_hash($user->password, PASSWORD_DEFAULT); //encriptado de contraseña
       $user->password=$incrip;
       $user->update();
       $this->addMessage("Se ha enviado a su correo una nueva contraseña temporal");
       
       //mail($correo, 
       //'Cambio de contraseña',  
       //"Hemos recibido su solicitud de cambio de contraseña y su nueva contraseña es: $newp");
       
    }
}