<?php namespace TimeTravel\Controller;
use Core\controller\PageBase;
use Core\mysql\Database;
use Core\session\User;
use Core\mysql\query\Select;
use Core\mysql\query\Update;
use Core\phtml\Template;


class ChangeP extends PageBase {
 function change(){
    if(isset($_GET["submit"])){
       //$html= new Template('ChangeP/formcp');
       $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz_-.$#';
       $correo=$_POST["correo"];
       $busqueda=new Select(User::table());
       $busqueda->condition("email", $correo);
       
       $resul=$busqueda->execute();
       $resul=$resul->fetch_all();
       $user=$resul;
       $tempc=str_shuffle($permitted_chars);
       
       //$user = new User("password");
       
       $user->password=$tempc;

       $db = Database::instance();
       $tabla = $db->storage(User::class);
       $tabla->save($user);
       


    }
   return new Template("Changep/formcp");
 }
}