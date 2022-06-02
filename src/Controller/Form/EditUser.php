<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Router\Router;

class EditUser extends Form
{
    protected User $currentUser;
    protected ?User $user;

    function __construct()
    {
        $this->access('admin');
        $this->styles[] = 'editadmin.css';

        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        $select->condition('id', $_GET['id']);
        $select->execute();
        $this->user = $select->fetch(User::class);
    }

    function init()
    {
        if (empty($this->user))
            return Router::get('/admin/usuarios');
        if ($this->user->id == $_SESSION['account']['user']->id)
            return Router::get('/perfil/editar');
        return parent::init();
    }

    function title(): string
    {
        return 'Editar información';
    }

    function content()
    {
        $image = null;
        if (!empty($this->user->avatar))
            $image = File::load($this->user->avatar);
        return new View('page/edit_user.phtml', [
            'pfp' => $image,
            'user' => $this->user
        ]);
    }

    public function verify(): bool
    {
        # $this->file = FileManager::get('avatar');
        # if (!is_null($this->file)) {
        #     FileManager::move($this->file, 'avatars');
        #     $this->file->save();
        # }
        return true;
    }

    function submit()
    {
        $this->user->username = $_POST['name'];
        $this->user->email = $_POST['email'];
        $this->user->rol = $_POST['rol'];
        # if (!is_null($this->file)) {
        #     $this->user->avatar = $this->file->id;
        # }
        $this->user->update();
        Message::add('Se ha actualizado su información');
    }
}
