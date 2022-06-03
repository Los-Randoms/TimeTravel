<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
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
        $user = User::load($_POST['id']);
        if (empty($user))
            return Router::get('/admin/usuarios');
        $archivo = File::load($user->avatar);
        return Router::get("/admin/usuario/editar");
    }

    public function verify(): bool
    {
        $this->file = FileManager::get('avatar');
        if (!is_null($this->file)) {
            FileManager::move($this->file, 'avatars');
            $this->file->save();
        }
        return true;
    }

    function submit()
    {

        if (!is_null($this->file)) {
            $this->user->avatar = $this->file->id;
            if (!empty($this->archivo)) {
                FileManager::delete($this->archivo);
            }
        }
        $this->user->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/admin/usuarios');
    }
}
