<?php namespace Controller\Page;

use Modules\Account\User;
use Modules\Kernel\Page;
use Modules\Kernel\Storage;

class ListFiles extends Page {

    function __construct() {
        parent::__construct('listfiles.phtml');
        

        
        /** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(User::TABLE);
		$select->execute();
        $this->user=$select->results(User::class);




    }
}