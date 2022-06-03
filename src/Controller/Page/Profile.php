<?php

namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Controller;
use Modules\Kernel\File;
use Modules\Kernel\View;

class Profile extends Controller
{
    function __construct()
    {
        $this->access();
        $this->styles[] = 'profile.css';
    }

    function title(): string
    {
        return $_SESSION['user']->username ?? 'Nadie';
    }

    function content()
    {
        return new View('page/profile.phtml');
    }
}

