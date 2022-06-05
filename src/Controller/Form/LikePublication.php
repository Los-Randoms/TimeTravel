<?php

namespace Controller\Form;

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
		$query = $this->db->read('likes');
		$query->condition('user', $_SESSION['user']->id);
		$query->condition('publication', $data['id']);
		$query->execute();
		$liked = !empty($query->fetch());
		if ($liked) {
			$query = $this->db->delete('likes');
			$query->condition('user', $_SESSION['user']->id);
			$query->condition('publication', $data['id']);
			$query->execute();
		} else {
			$query = $this->db->create('likes');
			$query->set('user', $_SESSION['user']->id, 'i');
			$query->set('publication', $data['id'], 'i');
			$query->execute();
		}

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
