<?php

namespace Controller\Page;

use Entity\Publication;
use Error;
use Modules\Kernel\Controller;
use Modules\Kernel\Message;
use Modules\Kernel\MessageTypes;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class Main extends Controller
{
	protected int $page;

	function __construct()
	{
		$this->styles[] = 'index.css';
		$this->page = $_GET['id'] ?? 1;
		if($this->page < 1)
			$this->page = 1;
	}

	function content()
	{
		/** @var \Modules\Mysql\Query\Select */
		$query = Storage::driver()
			->read(Publication::TABLE);
		$query->limit(15, $this->page);
		$query->execute();
		$publications = $query->results(Publication::class);

		return new View('page/index.phtml', [
			'publications' => $publications,
		]);
	}
}
