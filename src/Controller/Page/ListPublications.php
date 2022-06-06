<?php

namespace Controller\Page;

use Entity\Publication;
use Modules\Kernel\Controller;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;

class ListPublications extends Controller
{
    protected int $page = 0;
    protected Driver $db;

    function __construct()
    {
        $this->access('admin', 'editor');
        $this->page = $_GET['p'] ?? 0;
        if($this->page < 0)
            $this->page = 0;
        $this->db = Storage::driver();
        $this->styles[] = 'components/pager.css';
    }

    function title(): string
    {
        return 'Publicaciones';
    }

    function content()
    {
        $select = $this->db->read(Publication::TABLE);
        $select->limit(11, $this->page * 10);
        $select->execute();
        $publications = $select->results(Publication::class);
        return new View('page/publications_list.phtml', [
            'publications' => array_slice($publications, 0, 10),
            'has_next' => count($publications) > 10,
            'page' => $this->page,
        ]);
    }
}


