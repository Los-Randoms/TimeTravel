<?php

namespace Controller\Form;

use Modules\Router\Router;
use Entity\Publication;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;

class CreatePublication extends Form
{
	protected File $file;

	protected array $accepts = [
		'image/png',
		'image/jpeg',
		'image/gif',
	];

	function __construct()
	{
		$this->access('admin');
	}

	function title(): string
	{
		return 'Nueva publicacion';
	}

	function content()
	{
		return new View('page/create_publication.phtml');
	}

	function submit()
	{
		$pub = new Publication();
		Message::add('¡Publicacion creada!');
		return Router::get("/publicacion?id={$pub->id}");
	}

	function verify(): bool
	{
		if (!Form::verify($_POST, [
			'title' => '[!?#]string|10',
			'body' => '[!?#]string|1',
		])) $this->error('Verifique la informacion enviada');
		$this->file = FileManager::get('image');
		print_r($this->file);
		die;
		if (!in_array($this->file->mime, $this->accepted_mimes))
			return $this->error('La imagen enviada es incorrecta');
	}
}
