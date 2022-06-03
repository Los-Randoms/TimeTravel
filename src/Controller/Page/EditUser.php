<?php

namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Controller;
use Modules\Kernel\File;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Router\Router;

class EditUser extends Controller
{
    protected User $currentUser;
    protected ?User $user;

    function __construct()
    {
        $this->access('admin', 'moderator');
        $this->styles[] = 'edituser.css';

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
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Select */
        $consulta = $db->read('roles');
        $consulta->orderBy('id');
        $consulta->execute();
        
        $image = null;
        if (!empty($this->user->avatar))
            $image = File::load($this->user->avatar);
        return new View('page/edit_user.phtml', [
            'user' => $this->user,
            'image' => $image,
            'roles' => $consulta->results(),
        ]);

    }

}
