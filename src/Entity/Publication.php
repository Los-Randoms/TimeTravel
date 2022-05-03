<?php namespace Entity;

use Modules\Kernel\Entity;

class Publication extends Entity {
	const TABLE = 'publication';
	public bool $published = true;
	public string $title;
	public string $body;
	public ?int $image;
	public string $date;
	public int $autor;
}
