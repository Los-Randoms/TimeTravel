<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class EliAdmin extends Form
{

    function __construct()
    {
        parent::__construct('eliuser.phtml');

        $this->title('Editar información');
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(User::TABLE);
        $select->condition('id', $_GET['id']);
        $select->execute();
        /** @var User */
        $this->user = $select->fetch(User::class);
    }

    public function verify(): bool
    {
        if (!isset($_GET['id']))                      
            $this->error('No hay ningun usuario con ese id');         
        $_GET['id'] = trim($_GET['id']);              
        if (empty($_GET['id']))                        
            $this->error("No hay ningun usuario con ese id");
        return true;
    }

    function _submit(): ?string
    {
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Delete */ 
        $consulta = $db->delete('users');               
        $consulta->condition('id', $_GET['id']);        
        $consulta->execute();                           
        return ("Se ha eliminado el usuario");
    }
}

