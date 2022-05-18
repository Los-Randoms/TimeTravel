<?php namespace Controller\Page;

use Modules\Kernel\Page;

class EliminarRol extends Page {
	function __construct() {
		parent::__construct('Eliminar_Rol.phtml');
		$this->title('Eliminar Rol');
		$this->style('css/eliminar-rolstyle.css');

	}
}
