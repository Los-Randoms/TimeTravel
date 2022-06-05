<?php

namespace Controller\Form;

use Modules\Router\Router;
use Entity\Publication;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;

class CreatePublication extends Form
{
	protected Driver $db;
	protected ?File $file;
	protected array $accepts = [
		'image/png',
		'image/jpeg',
		'image/gif',
	];

	function __construct()
	{
		parent::__construct('POST', [
			'title' => [
				'from' => &$_POST,
				'trim' => true,
			],
			'body' => [
				'from' => &$_POST,
				'length' => 20,
				'trim' => true,
			],
			'type' => [
				'from' => &$_POST,
			],
			'image' => [
				'from' => &$_FILES,
			],
		]);
		$this->access('admin', 'editor');
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
		FileManager::move($this->file, 'publ');
		$this->file->save();
		$pub = new Publication();
		$pub->title = $data['title'];
		$pub->body = $data['body'];
		$pub->published = $data['action'] === 'Publicar';
		$pub->image = $this->file->id;
		$pub->autor = $_SESSION['user']->id;
		$pub->save();
		Message::add('¡Publicacion creada!');
		return Router::get("/publicacion?id={$pub->id}");
	}

	function verify(&$data)
	{
		$this->file = FileManager::get('image');
		if (empty($this->file))
			return Message::add('Debe de subir una imagen');
		if (!in_array($this->file->mime, $this->accepts))
			return Message::add('La imagen no esta en un formato aceptado');
		return true;
	}
}
