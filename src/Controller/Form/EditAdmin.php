<?php namespace Controller\Form;

use Modules\Account\User;

use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class EditAdmin extends Form{

    function __construct() {
        parent::__construct('editadmin.phtml');
        //$this->style('css/changep.css');
        $this->title('Editar información');
    }

    public function verify()
    {
        if(!Form::check($_POST, [
            'email' => '[!?#]string|',
            'name'=>'[!?#]string|',
            'rol'=>'[!?#]string|'
        ])) $this->error('Formulario invalido');
        
        /** @var \Modules\Mysql\Driver */
        $driver=Storage::driver();
        $select=$driver->read(User::TABLE);
        $select->condition('email', $_POST['email'], 's', '=');
        $select->condition('username', $_POST['name'], 's', '=');
        $select->condition('rol', $_POST['rol'], 's', '=');
        $select->execute();
         /** @var User */
        $this->user = $select->fetch(User::class);
        if(is_null($this->user))
            return false;
        return true;
        $this->file=FileManager::get('avatar');
        $this->file->moveTo('avatars');
        $this->file->save();
    }
    function _submit(): ?string {
        $mail=$_POST['email'];
		$name=$_POST['name'];
        $rol=$_POST['rol'];
        $this->avatar=$this->file->id;
        $this->user->username=$name;
        $this->user->email=$mail;
        $this->user->rol=$rol;
        $this->user->update();
        return("Se ha actualizado su información");
    }
}
