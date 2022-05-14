<?php namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class EditAdmin extends Form {
    function __construct() {
        parent::__construct('edituser.phtml');
        //$this->style('css/changep.css');
        $this->title('Editar información');
    }
    public function verify() {
    }

    
    function _submit(): ?string {
		return 'Sesion iniciada';
    }
}
