<?php namespace Controller\Form;

use Controller\Component\Navbar;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;

class CreatePublication extends Form {
	protected File $file;

	protected array $accepted_mimes = [
		'image/png',
		'image/jpeg',
		'image/gif',
	];

	function __construct() {
		parent::__construct('create_publication.phtml');
		$this->title('Nueva publicacion');
		$this->header[] = new Navbar;
		$this->access('admin');
	}

	function _submit(): ?string {
		return 'Publicacion creada';
	}

	function verify() {
		if(!Form::verify($_POST, [
			'title' => '[!?#]string|10',
			'body' => '[!?#]string|1',
		])) $this->error('Verifique la informacion enviada');
		$this->file = FileManager::get('image');
		print_r($this->file);
		die;
		if(!in_array($this->file->mime, $this->accepted_mimes))
			$this->error('La imagen enviada es incorrecta');
	}
}
