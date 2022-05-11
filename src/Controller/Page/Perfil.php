<?php namespace Controller\Page;                            //Indica donde esta el archivo 

use Modules\Kernel\Page;                                
use Modules\Kernel\Storage;
use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\File;

class Perfil extends Page {

    function __construct() {
		parent::__construct('perfildeusuario.phtml');       //Parte visual
        $this->style('css\perfil.css');                     //Parte CSS   
        $this->user = User::load(1);

        $this->imagen=null;

        if(!is_null($this->user->avatar)) {
            $this->imagen=File::load($this->user->avatar);
        }

    }
}