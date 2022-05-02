<?php namespace Controller\Component;

use Modules\Kernel\File;
use Modules\Kernel\View;

class Publication extends View {
	public function __construct(
		public string $title,
		public string $body,
		public File $image
	) {
		parent::__construct('component/publication.phtml');
	}
}
