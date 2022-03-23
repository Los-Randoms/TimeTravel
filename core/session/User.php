<?php namespace Core\session;

use Core\EntityBase;

class User extends EntityBase {
	public string $username;
	public string $password;
	public string $email;
	public string $role;


	static public function table(): string {
		return 'users';
	}
}
