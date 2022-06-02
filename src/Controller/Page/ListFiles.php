<?php

namespace Controller\Page;

use Modules\Kernel\Controller;
use Modules\Kernel\File;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class ListFiles extends Controller
{

    function __construct()
    {
        $this->access('admin');
    }

    function title(): string
    {
        return 'Ver archivos';
    }

    function content()
    {
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read('files');
        $select->execute();
        $files = $select->results(File::class);
        return new View('page/files_list.phtml', [
            'files' => $files
        ]);
    }
}

