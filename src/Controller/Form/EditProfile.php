<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Router;

class EditProfile extends Form
{
    function __construct()
    {
        $this->access();
        $this->styles[] = 'editprofile.css';
        
    }
    
    function title(): string
    {
        return 'Editar información';
    }

    function content()
    {
        return new View('page/edit_account.phtml', [
            'user' => $_SESSION['user'], 
            'image' => $_SESSION['pfp'],
        ]);
    }

    function verify(): bool
    {
        $this->file = FileManager::get('avatar');
        if (!empty($this->file)) {
            FileManager::move($this->file, 'avatars');
            $this->file->save();
        }
        return true;
    }

    function submit()
    {
        $_SESSION['user']->username = $_POST['name'];

        if (!empty($this->file)) {
            $_SESSION['user']->avatar = $this->file->id;
            $last_pfp = $_SESSION['pfp'];
            if(!empty($last_pfp)){
                FileManager::delete($last_pfp);
                $_SESSION['pfp'] = $this->file;
            }
        }
        $_SESSION['user']->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/perfil');
    }
}
