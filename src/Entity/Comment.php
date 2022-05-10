<?php namespace Entity;

use Modules\Kernel\Entity;

class Comment extends Entity {
	const TABLE = 'comments';
	public int $user;
	public int $publication;
	public string $date;
	public string $body;
}
