<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class ChangePass extends Form
{
    function __construct()
    {
        $this->style[] = 'change-password.css';
    }

    function title(): string
    {
        return 'Cambiar contraseña';
    }

    function content() {
        return new View('page/change_password.phtml');
    }

    function verify(): bool
    {
        # if (!Form::check($_POST, [
        #     'email' => '[!?#]string|',
        # ])) $this->error('Formulario invalido');

        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        $select->condition('email', $_POST['email'], 's', '=');
        $select->execute();
        /** @var User */
        $this->user = $select->fetch(User::class);
        if (is_null($this->user))
            return false;
        return true;
    }

    function submit()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz$#';
        //genera carcteres aleatorio
        $newp = substr(str_shuffle($permitted_chars), 0, 8); 
        //encriptado de contraseña
        $incrip = password_hash($newp, PASSWORD_DEFAULT); 
        $this->user->password = $incrip;
        $this->user->update();
        Message::add("Se ha enviado a su correo una nueva contraseña temporal {$newp}");

        // mail(
        //   $correo, 
        //   'Cambio de contraseña',  
        //   "Hemos recibido su solicitud de cambio de contraseña y su nueva contraseña es: $newp"
        // );
    }
}

