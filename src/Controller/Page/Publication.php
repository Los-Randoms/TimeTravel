<?php

namespace Controller\Page;

use Entity\Comment;
use Entity\Publication as EntityPublication;
use Modules\Account\Session;
use Modules\Account\User;
use Modules\Kernel\Controller;
use Modules\Kernel\File;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;
use Modules\Router\Router;

class Publication extends Controller
{
	protected ?EntityPublication $publication;
	protected Driver $db;

	function __construct()
	{
		$this->styles[] = 'publication.css';
		$this->publication = EntityPublication::load($_GET['id'] ?? 0);
		$this->db = Storage::driver();
	}

	function title(): string
	{
		return $this->publication->title;
	}

	function content()
	{
		if(empty($this->publication) || !$this->publication->published) {
			Message::add('La publicacion no existe');
			return Router::get('/');
		}

		$image = null;
		if(!empty($this->publication->image))
			$image = File::load($this->publication->image);

		$query = $this->db->read(Comment::TABLE);
		$query->condition('publication', $this->publication->id);
		$query->execute();
		$comments = $query->results(Comment::class);

		$liked = false;
		if(Session::logged()) {
			$query = $this->db->read('likes');
			$query->condition('user', $_SESSION['user']->id);
			$query->condition('publication', $this->publication->id);
			$query->execute();
			$liked = $query->fetch() !== null;
		}

		$likes = 0;
		$query = $this->db->read('likes');
		$query->select('count(user) as q');
		$query->condition('publication', $this->publication->id);
		$query->execute();
		$likes= $query->fetch()['q'] ?? 0;

		return new View('page/publication.phtml', [
			'publication' => $this->publication,
			'likes' => $likes,
			'image' => $image,
			'author' => User::load($this->publication->autor),
			'liked' => $liked,
			'comments' => $comments,
		]);
	}
}
