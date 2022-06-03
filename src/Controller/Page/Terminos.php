<?php

namespace Controller\Page;

use Controller\Component\Navbar;
use Modules\Kernel\Controller;
use Modules\Kernel\View;

class Terminos extends Controller
{
    function __construct()
    {
        $this->styles[] = 'terminos.css';
    }
    function content()
    {
        return new View('page/terminos.phtml');
    }
    function title(): string
    {
        return "Terminos y condiciones";
    }
}
