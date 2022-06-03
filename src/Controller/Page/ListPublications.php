<?php

namespace Controller\Page;

use Entity\Publication;
use Modules\Kernel\Controller;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class ListPublications extends Controller
{
    protected int $page = 1;

    function __construct()
    {
        $this->access('admin', 'editor');
        $this->page = $_GET['p'] ?? 1;
        if($this->page < 1)
            $this->page = 1;
    }

    function title(): string
    {
        return 'Publicaciones';
    }

    function content()
    {
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(Publication::TABLE);
        $select->condition('published', true, 'i');
        $select->limit(11, $this->page * 10);
        $select->execute();
        $publications = $select->results(Publication::class);
        return new View('page/publications_list.phtml', [
            'publications' => $publications,
        ]);
    }
}


