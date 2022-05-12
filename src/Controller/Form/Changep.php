<?php namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class Changep extends Form {
    function __construct() {
        parent::__construct('changep.phtml');
        $this->style('css/changep.css');
        $this->title('Cambiar contraseña');
    }

    public function verify(): bool
    {   
        if(!Form::check($_POST, [
            'email' => '[!?#]string|',
            ])) $this->error('Formulario invalido');
        
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

    function _submit(): ?string 
    {
       $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz$#';
       $newp=substr(str_shuffle($permitted_chars), 0, 8); //genera carcteres aleatorio
       $incrip = password_hash( $newp, PASSWORD_DEFAULT); //encriptado de contraseña
       $this->user->password=$incrip;
       $this->user->update();
       return("Se ha enviado a su correo una nueva contraseña temporal {$newp}");
       //mail($correo, 
       //'Cambio de contraseña',  
       //"Hemos recibido su solicitud de cambio de contraseña y su nueva contraseña es: $newp");
         
    }  
}