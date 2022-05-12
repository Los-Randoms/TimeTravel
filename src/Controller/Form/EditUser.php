<?php namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class EditUser extends Form {
    function __construct() {
        parent::__construct('edituser.phtml');
        //$this->style('css/changep.css');
        $this->title('Editar información');
    }
    public function verify(): bool
    {
        if(!isset($_POST['email']) || empty($_POST['email']))
        return false;
        if(!isset($_POST['password']) || empty($_POST['password']))
        return false;
    }

    
    public function _submit(){

    }
}
