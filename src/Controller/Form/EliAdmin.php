<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Response;
use Modules\Kernel\Storage;

class EliAdmin extends Form
{

    function __construct()
    {
        parent::__construct('editadmin.phtml');

        $this->title('Editar información');
        $this->style('css/editadmin.css');
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        $select->condition('id', $_GET['id']);
        $select->execute();
        /** @var User */
        $this->user = $select->fetch(User::class);
        $this->image = null;
        if (!is_null($this->user->avatar)) {
            $this->image = File::load($this->user->avatar);
        }

    }

    public function verify(): bool
    {
        if (!Form::check($_POST, [
            'email' => '[!?#]string|',
            'name' => '[!?#]string|',
            'rol' => '[!?#]string|'
        ])) $this->error('Formulario invalido');
        if (is_null($this->user))
            return false;
        return true;
    }

    function _submit(): ?string
    {
        $this->user->username = $_POST['name'];
        $this->user->email = $_POST['email'];
        $this->user->rol = $_POST['rol'];
        if(!is_null($this->file)){
            $this->user->avatar = $this->file->id;
        }
        $this->user->update();
        return ("Se ha actualizado su información");
    }
}
