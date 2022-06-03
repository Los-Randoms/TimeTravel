<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Router\Router;

class BanUser extends Form
{
    protected ?User $user;

    function __construct()
    {
        $this->access('admin', 'moderator');
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        $select->condition('id', $_GET['id']);
        $select->execute();
        $this->user = $select->fetch(User::class);
    }

    function title(): string
    {
        return 'Banear usuario';
    }

    function content()
    {

        return new View('page/ban-user.phtml', [
            "user"=> $this->user
        ]);
    }

    public function verify(): bool
    {
        if (empty($this->user))
            return $this->error('El usuario no existe');
        return true;
    }

    function submit()
    {
        $this->user->banned=!$this->user->banned;
        $this->user->update();
        if($this->user->banned){
            Message::add('Se ha baneado al usuario');
        } else{
            Message::add('Se ha desbaneado al usuario');
        }
        return Router::get('/admin/usuarios');
    }
}
