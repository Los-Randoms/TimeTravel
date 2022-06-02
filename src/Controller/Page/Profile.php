<?php

namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Controller;
use Modules\Kernel\File;
use Modules\Kernel\View;

class Profile extends Controller
{
    protected User $user;
    protected ?File $pfp;

    function __construct()
    {
        $this->access();
        $this->styles[] = 'profile.css';
        if($_SESSION['account']['logged']) {
            $this->user = $_SESSION['account']['user'];
            $this->pfp = $_SESSION['account']['pfp'];
        }
    }

    function title(): string
    {
        return $this->user->username ?? 'Nobody';
    }

    function content()
    {
        return new View('page/profile.phtml', [
            'user' => $this->user,
            'pfp' => $this->pfp
        ]);
    }
}

