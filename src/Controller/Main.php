<?php namespace MinPHP\Controller;
use Core\controller\PageBase;
use Core\mysql\Database;
use Core\phtml\Template;
use MinPHP\Entities\User;

class Main extends PageBase {
	public function index() {
		return new Template('index');
	}
}
