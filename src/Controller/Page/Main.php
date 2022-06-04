<?php

namespace Controller\Page;

use Entity\Publication;
use Modules\Kernel\Controller;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;

class Main extends Controller
{
	protected int $page;
	protected Driver $db;

	function __construct()
	{
		$this->styles[] = 'index.css';
		$this->page = $_GET['id'] ?? 1;
		if($this->page < 1)
			$this->page = 1;
		$this->db = Storage::driver();
	}

	function content()
	{
		$query = $this->db
			->read(Publication::TABLE);
		$query->limit(15, $this->page);
		$query->execute();
		$publications = $query->results(Publication::class);

		return new View('page/index.phtml', [
			'publications' => $publications,
		]);
	}
}
