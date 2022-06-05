<?php

namespace Controller\Form;

use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Router;

class EditProfile extends Form
{
    protected File $file;

    function __construct()
    {
        parent::__construct('POST', [
            'name' => [
                'trim' => true,
                'from' => &$_POST,
            ],
            'avatar' => [
                'from' => &$_FILES,
                'optional' => true,
            ],
        ]);
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

    function verify(&$data)
    {
        $this->file = FileManager::get('avatar');
        if (!empty($this->file)) {
            FileManager::move($this->file, 'avatars');
            $this->file->save();
        }
        return true;
    }

    function submit(&$data)
    {
        $_SESSION['user']->username = $data['name'];
        if (!empty($this->file)) {
            $_SESSION['user']->avatar = $this->file->id;
            $last_pfp = $_SESSION['pfp'];
            if (!empty($last_pfp)) {
                FileManager::delete($last_pfp);
                $_SESSION['pfp'] = $this->file;
            }
        }
        $_SESSION['user']->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/perfil');
    }
}
