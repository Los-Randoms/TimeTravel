<?php namespace Modules\Kernel;

use Exception;
use Modules\Account\Session;
use ReflectionClass;
use ReflectionMethod;

abstract class Page extends View {
	private string $styleSheet;
	private string $script;
	private string $title;
	private array $permissions = [];
	protected array $header = [];
	protected array $footer = [];

	function render(): bool {
		ob_start();
		include "src/Templates/page_template.phtml";
		return ob_end_flush();
	}

	protected function title(string $title) {
		$this->title = $title;
	}

	protected function style(string $href) {
		$this->styleSheet = $href;
	}

	protected function script(string $src) {
		$this->script = $src;
	}

	protected function access(string ...$roles) {
		$this->permissions = $roles;
	}

	public function init(): ?ReflectionMethod {
		// Check if the user has permissions
		if(!empty($this->permissions)) {
			if(!Session::started())
				throw new Exception('Permiso denegado', 403);
			/** @var \Modules\Account\User */
			$user = $_SESSION['user'];
			if(!in_array($user->role, $this->permissions))
				throw new Exception('Permiso denegado', 403);
		}
		
		// Process the event
		$event = $_GET['e'] ?? null;
		if(isset($event) && !empty($event)) {
			$refl = new ReflectionClass(static::class);
			if($refl->hasMethod("_$event")) {
				$method = $refl->getMethod("_$event");
				$name = $method->getName();
				if(strpos($name, '__') !== 0)
					return $method;
			}
		}
		return null;
	}
}
