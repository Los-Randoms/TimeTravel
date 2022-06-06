<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;


class ChangePassUser extends Form
{
    protected Driver $db;
    protected ?User $user;

    function __construct()
    {
        parent::__construct('POST', [
			'old_pass' => [
				'trim' => true,
				'from' => &$_POST,
			],
            'new_pass' => [
				'trim' => true,
				'from' => &$_POST,
			],
		]);
        $this->access('');
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
        $select = $this->db->read(User::TABLE);
        $select->condition('old_pass', $data['old_pass']);
        $select->condition('banned', false, 'i');
        $select->execute();
        $this->user = $select->fetch(User::class);
        if (empty($this->user)){
            return Message::add('Vefique la informacion proporcionada');
        }
    }

    function submit(&$data)
    {
        $this->new_pass=$data['new_pass'];
        $this->user->password = password_hash($this->new_pass, PASSWORD_BCRYPT);
        $this->user->update();
        Message::add('¡Se ha registrado correctamente!');
    }
}