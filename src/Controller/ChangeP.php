<?php namespace TimeTravel\Controller;
use Core\controller\PageBase;
use Core\session\User;
use Core\mysql\query\Select;
use Core\phtml\Template;

class ChangeP extends PageBase {
 function change(){
    if(isset($_GET['submit'])) {
        $mail = $_POST['correo'] ?? null;
        
			$query = new Select('users');
			$query->condition('email', $mail);
			$result = $query->execute();
			$user = $result->fetch_object(User::class);

    
    
    
    }
    return new Template('Changep/formcp');
 }
}