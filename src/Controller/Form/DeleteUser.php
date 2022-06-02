<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class DeleteUser extends Form
{
    protected ?User $user;

    function __construct()
    {
        $this->access('admin');
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        $select->condition('id', $_GET['id']);
        $select->execute();
        $this->user = $select->fetch(User::class);
    }

    function title(): string
    {
        return 'Eliminar usuario';
    }

    function content()
    {
        return new View('page/delete_user.phtml');
    }

    public function verify(): bool
    {
        if (empty($this->user))
            return $this->error('El usuario no existe');
        return true;
    }

    function submit()
    {
        User::remove($this->user->id);
        Message::add('Se ha eliminado el usuario');
    }
}
