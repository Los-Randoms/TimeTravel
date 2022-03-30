<?php namespace TimeTravel\Controller;
use Core\controller\PageBase;
use Core\mysql\Database;
use Core\session\User;
use Core\mysql\query\Select;
use Core\phtml\Template;

$mysql_database = "TimeTrave";


class ChangeP extends PageBase {
 function change(){
    if(isset($_GET["submit"])){
       //$html= new Template('ChangeP/formcp');
       $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz_-.$#';
       $correo = $_POST["correo"];
       $busqueda = new Select(User::table());
       $busqueda->condition("email", $correo);
       
       $resul = $busqueda->execute();
        
       echo '<pre>';
       $res=$resul->fetch_object(User::class);
       print_r($res->password);
       $res->password='asdasdsdas';
       echo PHP_EOL;
       print_r($res->password);

       $database=Database::instance();
       $storage=$database->storage(User::class);
       $storage->update($res);
    }
   return new Template("Changep/formcp");
 }
}