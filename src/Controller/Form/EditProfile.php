<?php

namespace Controller\Form;

use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;

class EditProfile extends Form
{
    protected User $currentUser;
    function __construct()
    {
        $this->access();
        $this->styles[] = 'edituser.css';
    }

    function title(): string
    {
        return 'Editar información';
    }

    function init() {
        $this->currentUser = $_SESSION['account']['user'];
        return parent::init();
    }

    function content()
    {
        $image = $_SESSION['account']['pfp'];
        return new View('page/edit_account.phtml', [
            'user' => $this->currentUser,
            'image' => $image,
        ]);
    }

    function verify(): bool
    {
        return true;
    }

    function submit()
    {
        $this->currentUser->username = $_POST['name'];
        $this->currentUser->update();
        Message::add('Se ha actualizado su información');
    }
}
