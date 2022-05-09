<?php namespace Modules\Account;

use Modules\Kernel\Entity;

class Permission extends Entity {
	const TABLE = 'permission';
	public string $name;
}
