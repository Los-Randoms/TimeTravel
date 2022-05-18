<?php namespace Controller\Page;


use Modules\Kernel\File;
use Modules\Kernel\Page;
use Modules\Kernel\Storage;

class ListFiles extends Page {

    function __construct() {
        parent::__construct('listfiles.phtml');
        $this->title('Ver archivos');
        /** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read('files');
		$select->execute();
        $this->files=$select->results(File::class);
    }
}