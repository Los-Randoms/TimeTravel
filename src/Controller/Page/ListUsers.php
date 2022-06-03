<?php

namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Controller;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class ListUsers extends Controller
{
    function __construct()
    {
        $this->access('admin', 'moderator');
    }

    function title(): string
    {
        return 'Usuarios';
    }

    function content()
    {
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        $select->execute();
        $usuarios = $select->results(User::class);
        return new View('page/users_list.phtml', [
            'users' => $usuarios,
        ]);
    }
}

