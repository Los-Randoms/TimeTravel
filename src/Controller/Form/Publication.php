<?php namespace Controller\Form;

use Entity\Publication as EntityPublication;
use Modules\Kernel\File;
use Modules\Kernel\Form;
use Modules\Kernel\Session;
use Modules\Kernel\User;

class Publication extends Form {
	public ?EntityPublication $pub;
	public User $currentUser;

	function __construct() {
		parent::__construct('publication.phtml');
		$this->setTitle('Publicacion');
		$this->currentUser = Session::currentUser();
		if(isset($_GET['id']) && is_numeric($_GET['id']))
			$this->pub = EntityPublication::load($_GET['id']);
	}

	function _submit() {
		$this->pub = new EntityPublication;
		$this->pub->autor = $this->currentUser->id;
		$this->pub->published = $_POST['published'] ?? true;
		$this->pub->title = $_POST['title'];
		$this->pub->body = $_POST['body'];
		$file = File::getUploadedFile('image');
		if(!empty($file)) {
			$file->moveTo('publication_images');
			$file->save();
			$this->pub->image = $file->id;
		}

		if(isset($this->pub->id))
			$this->pub->update();
		else
			$this->pub->save();
	}

	function verify(): bool {
		if(!isset($_POST['title']) || empty($_POST['title'])) {
			$this->addMessage('Agrega un titulo');
			return false;
		}

		if(!isset($_POST['body']) || empty($_POST['body'])) {
			$this->addMessage('Agregue un contenido');
			return false;
		}

		return true;
	}
}
