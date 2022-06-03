<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Router\Router;

class EditPFP extends Form
{

    function __construct()
    {
        $this->access('admin');
        $this->styles[] = 'editadmin.css';
    }

    function content()
    {
        return Router::get("/admin/usuario/editar");
    }

    public function verify(): bool
    {
        return true;
    }

    function submit()
    {
        $user = User::load($_POST['id']);
        $file = FileManager::get('avatar');
        if (!empty($file)) {
            FileManager::move($file, 'avatars');
            $file->save();
            $user->avatar = $file->id;
        }
        $user->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/admin/usuarios');
    }
}
