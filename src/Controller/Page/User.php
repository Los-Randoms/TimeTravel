<?php

namespace Controller\Page;

use Modules\Account\User as AccountUser;
use Modules\Kernel\Controller;
use Modules\Kernel\File;
use Modules\Kernel\View;

class User extends Controller
{
	protected ?AccountUser $user;

	function __construct()
	{
		$this->styles[] = 'profile.css';
		$this->user = AccountUser::load($_GET['id'] ?? 0);
	}

	function title(): string
	{
		return $this->user->username ?? 'Nadie';
	}

	function content()
	{
		$pfp = null;
		if(!empty($this->user->avatar))
			$pfp = File::load($this->user->avatar);
		return new View('page/profile.phtml', [
			'pfp' => $pfp,
			'user' => $this->user,
		]);
	}
}
