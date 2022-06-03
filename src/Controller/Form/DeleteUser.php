<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Router\Router;

class DeleteUser extends Form
{
    protected ?User $user;

    function __construct()
    {
        $this->access('admin', 'moderator');
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
        if(!empty($this->file)){
            FileManager::delete($this->file);
        }
        User::remove($this->user->id);
        Message::add('Se ha eliminado el usuario');
        return Router::get('/admin/usuarios');
    }
}
