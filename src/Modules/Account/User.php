<?php namespace Modules\Account;

use Modules\Kernel\Entity;

class User extends Entity {
	const TABLE = 'users';
	public string $username;
	public string $email;
	public string $password;
	public ?string $rol;
	public ?int $avatar;
	public bool $banned;
	public string $creation;
}
