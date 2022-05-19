<?php namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Page;
use Modules\Kernel\Query;
use Modules\Kernel\Storage;
use mysqli;

class Roles extends Page {

    function __construct() {
        parent::__construct('roles.phtml');
        $this->style('css\roles.css');

        $this->user = User::load(1);            //Solo el usuario con ese ID puede verlo

        /** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();            //Trae la base de datos
		$select = $driver->read('roles');
        $select->orderBy('id');       //Lee la base de datos

		$select->execute();                     //ejecuta
        $this->role= $select->results();        //trae los resultados
    }
}