<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;
use Modules\Router\Router;

class BanUser extends Form
{
    protected ?User $user;
    protected Driver $db;

    function __construct()
    {
        parent::__construct('POST', [
            'id' => [
                'from' => &$_POST,
                'type' => 'integer',
            ],
        ]);
        $this->access('admin', 'moderator');
        $this->db = Storage::driver();
    }

    function title(): string
    {
        return 'Banear usuario';
    }

    function content()
    {
        if(!isset($this->user))
            $this->user = User::load($_GET['id']);
        return new View('page/ban-user.phtml', [
            "user" => $this->user
        ]);
    }

    public function verify(&$data)
    {
        $this->user = User::load($data['id']);
        if (empty($this->user))
            return Message::add('El usuario no existe');
        return true;
    }

    function submit(&$data)
    {
        $this->user->banned = !$this->user->banned;
        $this->user->update();
        if($this->user->banned)
            Message::add('Se ha baneado al usuario');
        else
            Message::add('Se ha desbaneado al usuario');
        return Router::get('/admin/usuarios');
    }
}
