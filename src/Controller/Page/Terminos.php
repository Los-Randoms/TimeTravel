<?php
namespace Controller\Page;

use Controller\Component\Navbar;
use Modules\Kernel\Page;
use Modules\Kernel\View;

class Terminos extends Page {
    function __construct(){
        parent::__construct('terminos.phtml');
		$this->style('css/terminos.css');
        $this->header[] = new Navbar();
    }
}