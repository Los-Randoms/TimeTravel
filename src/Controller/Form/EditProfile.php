<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Router;

class EditProfile extends Form
{
    protected User $currentUser;
    function __construct()
    {
        $this->access();
        $this->styles[] = 'editprofile.css';
    }

    function title(): string
    {
        return 'Editar información';
    }

    function init()
    {
        $this->currentUser = $_SESSION['account']['user'];
        return parent::init();
    }

    function content()
    {
        $image = $_SESSION['account']['pfp'];
        return new View('page/edit_account.phtml', [
            'user' => $this->currentUser,
            'image' => $image
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
        }
        $this->currentUser->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/perfil');
    }
}
