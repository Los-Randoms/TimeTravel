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
    protected User $user;
    protected ?File $file;

    function __construct()
    {
        parent::__construct('POST', [
            'id' => [
                'type' => 'integer',
                'trim' => true,
                'from' => &$_POST,
            ],
            'avatar' => [
                'from' => &$_FILES,
            ],
        ]);
        $this->access('admin');
        $this->styles[] = 'editadmin.css';
    }

    function content()
    {
        return Router::get("/admin/usuario/editar");
    }

    public function verify(&$data)
    {
        $this->user = User::load($data['id']);
        $this->file = FileManager::get('avatar');
        if(empty($this->user))
            return Message::add('El usuario no existe');
        if(empty($this->file))
            $this->file = FileManager::get('avatar');
        return true;
    }

    function submit(&$data)
    {
        FileManager::move($this->file, 'avatars');
        $this->file->save();
        $this->user->avatar = $this->file->id;
        $this->user->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/admin/usuarios');
    }
}
