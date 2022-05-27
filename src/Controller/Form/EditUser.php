<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class EditUser extends Form
{

    function __construct()
    {
        parent::__construct('edituser.phtml');
        $this->title('Editar información');
        $this->style('css/edituser.css');
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        
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
            'name' => '[!?#]string|'
        ])) $this->error('Formulario invalido');
        if (is_null($this->user))
            return false;

        
        $this->file = FileManager::get('avatar');
        if(!is_null($this->file)) {
            FileManager::move($this->file, 'avatars');
            $this->file->save();
        }
        return true;
    }

    function _submit(): ?string
    {
        $this->user->username = $_POST['name'];
        if(!is_null($this->file)){
            $this->user->avatar = $this->file->id;
        }
        $this->user->update();
        return ("Se ha actualizado su información");
    }
}
