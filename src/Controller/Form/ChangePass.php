<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;
use Modules\Router\Router;

class ChangePass extends Form
{
    protected Driver $db;
    protected ?User $user;

    function __construct()
    {
        parent::__construct('POST', [
            'email' => [
                'trim' => true,
                'from' => &$_POST,
                'filter' => [
                    'type' => FILTER_VALIDATE_EMAIL
                ],
            ],
        ]);
        $this->db = Storage::driver();
        $this->styles[] = 'change-password.css';
    }

    function title(): string
    {
        return 'Cambiar contraseña';
    }

    function content()
    {
        return new View('page/change_password.phtml');
    }

    function verify(&$data)
    {
        $select = $this->db->read(User::TABLE);
        $select->condition('email', $data['email']);
        $select->condition('banned', false, 'i');
        $select->execute();
        $this->user = $select->fetch(User::class);
        if (empty($this->user))
            return Message::add('Vefique la informacion proporcionada');
    }

    function submit(&$data)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz$#';
        // Genera carcteres aleatorio
        $password = substr(str_shuffle($permitted_chars), 0, 12);
        $this->user->password = password_hash($password, PASSWORD_BCRYPT);
        $this->user->update();
        // mail(
        //   $correo, 
        //   'Cambio de contraseña',  
        //   "Hemos recibido su solicitud de cambio de contraseña y su nueva contraseña es: $newp"
        // );
        Message::add('Se ha enviado a su correo una nueva contraseña temporal');
        return Router::get('/iniciar-sesion');
    }
}
