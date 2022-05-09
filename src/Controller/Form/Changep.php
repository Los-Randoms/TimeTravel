<?php namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;



class Changep extends Form {
    function __construct()
    {
        parent::__construct('changep.phtml');
        $this->style('css/changep.css');
        $this->title('Cambiar contraseña');
    }

    public function verify(): bool
    {
        if(!isset($_POST['email']) || empty($_POST['email']))
            return false;
        
        /** @var \Modules\Mysql\Driver */
        $driver=Storage::driver();
        $select=$driver->read(User::TABLE);
        $select->condition('email', $_POST['email'], 's', '=');
        $select->execute();
         /** @var User */
        $this->user = $select->fetch(User::class);
        if(is_null($this->user))
            return false;
        return true;
    }

    public function _submit()
    {
    
       $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz$#';
       $newp=substr(str_shuffle($permitted_chars), 0, 8); //genera carcteres aleatorio
       //fetch_object es para que los resultados de la busqueda se guarden como un objeto, y para poder buscar un objeto 
       //se puede poner print_r($res->"Lo que sea que estes buscando");
       $this->user->password=$newp;
       $incrip = password_hash( $this->user->password, PASSWORD_DEFAULT); //encriptado de contraseña
       $this->user->password=$incrip;
       $this->user->update();
       //$this->error("Se ha enviado a su correo una nueva contraseña temporal");
       
       //mail($correo, 
       //'Cambio de contraseña',  
       //"Hemos recibido su solicitud de cambio de contraseña y su nueva contraseña es: $newp");
         
    } 
} 
