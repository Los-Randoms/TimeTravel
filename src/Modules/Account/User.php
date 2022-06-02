<?php namespace Modules\Account;

use Modules\Kernel\Entity;

class User extends Entity {
	const TABLE = 'users';
	public string $username;
	public string $email;
	public string $password;
	public string $rol = 'user';
	public ?int $avatar;
	public int $banned = 0;
	public string $creation;
}
