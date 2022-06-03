<?php

namespace Controller\Form;

use Controller\Page\Roles;
use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Router\Router;

class EditName extends Form
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
        $select->condition('id', $_POST['id']);
        $select->execute();
        $this->user = $select->fetch(User::class);

        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read('roles');
        $select->condition('id', $_POST['rol']);
        $select->execute();
        $this->rol = $select->fetch();
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

        return true;
    }

    function submit()
    {
        
        $this->user->rol =  $this->rol['name'];
        $this->user->username = $_POST['name'];
        $this->user->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/admin/usuarios');
    }
}
