<?php namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Page;
use Modules\Kernel\Storage;


class ListUsers extends Page {

    function __construct() {
        parent::__construct('listusers.phtml');
        $this->style('css/changep.css');
        $this->title('Ver usuarios');
        $this->user = User::load(1);            

        /** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();            
		$select = $driver->read('users');       
		$select->execute();                     
        $this->usuarios= $select->results();        
    }
}