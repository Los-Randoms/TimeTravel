<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;
use Modules\Router\Router;

class ChangePassUser extends Form
{
    protected Driver $db;
    protected ?User $user;

    function __construct()
    {
        parent::__construct('POST', [
			'old_pass' => [
                'trim' =>false,
				'from' => &$_POST,
			],
            'new_pass' => [
                'trim' =>false,
				'from' => &$_POST,
			],
		]);
        $this->access();
        $this->db = Storage::driver();
        
    }

    function title(): string
    {
        return 'Cambiar contraseña';
    }

    function content()
    {
        return new View('page/change_pass_user.phtml');
    }

    function verify(&$data)
    {
        $this->user= $_SESSION['user'];
        if (empty($this->user)){
            return Message::add('Vefique la informacion proporcionada');
        }
        if (!password_verify($data['old_pass'], $this->user->password)){
            return Message::add('Verifique los datos');
        } 
        $this->new_pass=$data['new_pass'];
        return true;
    }

    function submit(&$data)
    {
        $this->new_pass=$data['new_pass'];
        $this->user->password = password_hash($this->new_pass, PASSWORD_BCRYPT);
        $this->user->update();
        Message::add('¡Se ha cambiado la contraseña correctamente!');
        return Router::get('/perfil/editar');
    }
}