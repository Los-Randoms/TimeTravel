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
            'user' => $_SESSION['account'], 
            'image' => $_SESSION['pfp'],
        ]);
    }

    function verify(): bool
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
        $this->currentUser->username = $_POST['name'];

        if (!is_null($this->file)) {
            $this->currentUser->avatar = $this->file->id;
            if(!empty($this->archivo)){
                FileManager::delete($this->archivo);
            }
        }
        $this->currentUser->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/perfil');
    }
}
