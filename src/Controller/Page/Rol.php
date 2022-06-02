<?php

namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Page;
use Modules\Kernel\Storage;

class Rol extends Page
{
    function __construct()
    {
        parent::__construct('rol.phtml');
        $this->style('css\rol.css');

        $this->user = User::load(1);            //Solo el usuario con ese ID puede verlo

        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();            //Trae la base de datos
        $select = $driver->read('roles');
        $select->orderBy('id');       //Lee la base de datos

        $select->execute();                     //ejecuta
        $this->role = $select->results();        //trae los resultados
    }
}

