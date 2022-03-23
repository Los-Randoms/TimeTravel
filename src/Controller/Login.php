<?php namespace TimeTravel\Controller;
use Core\controller\PageBase;
use Core\mysql\query\Select;
use Core\phtml\Template;
use Core\session\Session;
use Core\session\User;

class Login extends PageBase {
	// La ruta del controlador de login
	function log_in() {
		$current_session = Session::current_session();
		if($current_session->isLogged())
			echo 'Sesion ya iniciada';
		// 	Si el usuario envio informacion
		if(isset($_GET['submit'])) {
			// Instancia de la base de datos
			$mail = $_POST['correo'] ?? null;
			$password = $_POST['contraseña'] ?? null;

			$query = new Select('users');
			$query->condition('email', $mail);
			$result = $query->execute();
			$user = $result->fetch_object(User::class);

			$isValid = password_verify($password, $user->password);
			if($isValid) {
				session_start();
				$_SESSION['user_id'] = $user->id;
				echo 'Sesion iniciada';
			} else 
				echo 'Inforamcion invalida';
		}
	
		// Envio la template del formulario de login
		return new Template('login/form');
	}
}
