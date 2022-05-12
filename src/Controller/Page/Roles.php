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

        $this->user = User::load(1);        //Solo el usuario con ese ID puede verlo

        /** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(User::TABLE);
		$select->condition('rol', $this->user->rol);
		$select->execute();
        $this->user=$select->fetch(User::class);




    }
}