<?php

namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Controller;
use Modules\Kernel\File;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;
use Modules\Router\Router;

class EditUser extends Controller
{
    protected Driver $db;

    function __construct()
    {
        $this->access('admin', 'moderator');
        $this->styles[] = 'edituser.css';
        $this->db = Storage::driver();
    }

    function title(): string
    {
        return 'Editar usuario';
    }

    function content()
    {
        $query = $this->db->read(User::TABLE);
        $query->condition('id', $_GET['id']);
        $query->execute();
        $user = $query->fetch(User::class);
        if(empty($user))
            return Router::get('/admin/usuarios');
        if($user->id === $_SESSION['user']->id)
            return Router::get('/perfil/editar');
        $query = $this->db->read('roles');
        $query->orderBy('id');
        $query->execute();
        $roles = $query->results();
        
        $image = null;
        if (!empty($user->avatar))
            $image = File::load($user->avatar);

        return new View('page/edit_user.phtml', [
            'user' => $user,
            'image' => $image,
            'roles' => $roles,
        ]);

    }

}
