<?php

namespace Controller\Form;

use Entity\Comment;
use Entity\Publication;
use Modules\Router\Router;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Mysql\Driver;

class LikePublication extends Form
{
  protected Driver $db;
  protected ?Publication $pub;

	function __construct()
	{
		parent::__construct('POST', [
			'id' => [
        'from' => &$_POST,
        'type' => 'integer',
			],
		]);
		$this->access();
		$this->db = Storage::driver();
	}

	function content()
  {
		return Router::get("/publicacion?id={$_POST['id']}");
	}

	function submit(&$data)
  {
    $comment = new Comment();
    $comment->publication = $this->pub->id;
    $comment->body = $data['body'];
    $comment->user = $_SESSION['user']->id;
		$comment->save();
		Message::add('¡Comentario creado!');
		return Router::get("/publicacion?id={$data['id']}");
	}

	function verify(&$data)
  {
    $this->pub = Publication::load($data['id']);
    if(empty($this->pub)) {
        Message::add('La publicacion no existe');
        return Router::get("/publicacion?id={$data['id']}");
    }
		return true;
	}
}
