<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Router;

class DeleteUser extends Form
{
    protected ?User $user;

    function __construct()
    {
        parent::__construct('POST', [
            'id' => [
                'from' => &$_POST,
                'type' => 'integer',
            ],
        ]);
        $this->access('admin');
    }

    function title(): string
    {
        return 'Eliminar usuario';
    }

    function content()
    {
        return new View('page/delete_user.phtml');
    }

    public function verify(&$data)
    {
        $this->user = User::load($data['id']);
        if (empty($this->user))
            return Message::add('El usuario no existe');
        if (!empty($this->user->avatar))
            $this->file = File::load($this->user->avatar);
        return true;
    }

    function submit(&$data)
    {
        if (isset($this->file) && !empty($this->file))
            FileManager::delete($this->file);
        User::remove($this->user->id);
        Message::add('Se ha eliminado el usuario');
        return Router::get('/admin/usuarios');
    }
}
