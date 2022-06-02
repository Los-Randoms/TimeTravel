<?php

namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Controller;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class Roles extends Controller
{
    function __construct()
    {
        $this->access('admin');
        $this->styles[] = 'roles.css';
    }

    function title(): string {
        return 'Roles';
    }

    function content() {
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read('roles');
        $select->orderBy('id');
        $select->execute();
        $roles = $select->results();
        return new View('page/roles_list.phtml', [
            'roles' => $roles,
        ]);
    }
}

