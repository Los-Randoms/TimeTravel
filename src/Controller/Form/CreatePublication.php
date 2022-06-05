<?php

namespace Controller\Form;

use Modules\Router\Router;
use Entity\Publication;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;

class CreatePublication extends Form
{
	protected Driver $db;
	protected array $accepts = [
		'image/png',
		'image/jpeg',
		'image/gif',
	];

	function __construct()
	{
		parent::__construct('POST', [
			'image' => [
				'from' => &$_FILES,
			],
		]);
		$this->access('admin');
		$this->db = Storage::driver();
	}

	function title(): string
	{
		return 'Nueva publicacion';
	}

	function content()
	{
		return new View('page/create_publication.phtml');
	}

	function submit(&$data)
	{
		$pub = new Publication();
		Message::add('¡Publicacion creada!');
		return Router::get("/publicacion?id={$pub->id}");
	}

	function verify(&$data)
	{
		$this->file = FileManager::get('image');
		print_r($this->file);
		die;
		if (!in_array($this->file->mime, $this->accepted_mimes))
			return Message::add('La imagen no esta en un formato aceptado');
	}
}
