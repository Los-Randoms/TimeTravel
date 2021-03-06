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
		$this->styles[] = 'components/pager.css';
		$this->page = $_GET['p'] ?? 0;
		if($this->page < 0)
			$this->page = 0;
		$this->db = Storage::driver();
	}

	function content()
	{
		$query = $this->db
			->read(Publication::TABLE);
		$query->condition('published', true, 'i');
		$query->limit(15, $this->page * 14);
		$query->execute();
		$publications = $query->results(Publication::class);

		return new View('page/index.phtml', [
			'publications' => array_slice($publications, 0, 14),
			'has_next' => count($publications) > 14,
			'page' => $this->page,
		]);
	}
}
