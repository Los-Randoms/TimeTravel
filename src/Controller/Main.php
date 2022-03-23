<?php namespace TimeTravel\Controller;
use Core\controller\PageBase;
use Core\mysql\Database;
use Core\phtml\Template;

class Main extends PageBase {
	public function index() {
		return new Template('index');
	}
}
