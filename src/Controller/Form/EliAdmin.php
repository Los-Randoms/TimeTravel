<?php namespace Controller\Form;

use Modules\Kernel\Form;

class EliAdmin extends Form{
    function __construct() {
        parent::__construct('eliuser.phtml');
        //$this->style('css/changep.css');
        $this->title('Editar información');
    }


    public function verify()
    {
        if(!Form::check($_POST, [
            'email' => '[!?#]string|',
            'password' => '[!?#]string|',
        ])) $this->error('Formulario invalido');
    }
    function _submit(): ?string {
        return 'Sesion iniciada';
    }
}

