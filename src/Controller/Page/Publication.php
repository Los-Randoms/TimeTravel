<?php namespace Controller\Page;

use Controller\Component\Navbar;
use Modules\Kernel\Page;

class Publication extends Page{
    function __construct()
    {
        parent::__construct('publication.phtml');
        $this->header[] = new Navbar();
        $this->style("css/publication.css");
    }
}