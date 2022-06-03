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

class EditPFP extends Form

{
    protected User $currentUser;
    protected ?User $user;

    function __construct()
    {
        $this->access('admin');
        $this->styles[] = 'editadmin.css';

        $this->user=User::load($_POST['id']);
        if(!is_null(File::load($this->user->avatar))){
            $this->archivo = File::load($this->user->avatar);
        }
    }

    function init()
    {
        if (empty($this->user))
            return Router::get('/admin/usuarios');
            if ($this->user->id == $_SESSION['account']['user']->id)
            return Router::get('/perfil/editar');
            return parent::init();
        }
        
    function content()
    {
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
            if(!empty($this->archivo)){
                FileManager::delete($this->archivo);
            }
        }
        $this->user->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/admin/usuarios');
    }
}
