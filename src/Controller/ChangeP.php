<?php namespace TimeTravel\Controller;
use Core\controller\PageBase;
use Core\mysql\Database;
use Core\session\User;
use Core\mysql\query\Select;
use Core\phtml\Template;

class ChangeP extends PageBase {
 function change(){
    if(isset($_GET["submit"])){
       //$html= new Template('ChangeP/formcp');
       $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz$#';
       $correo = $_POST["correo"];
       $busqueda = new Select(User::table());
       $busqueda->condition("email", $correo);
       $resul = $busqueda->execute();

       $newp=substr(str_shuffle($permitted_chars), 0, 8); //genera carcteres aleatorio

       //fetch_object es para que los resultados de la busqueda se guarden como un objeto, y para poder buscar un objeto 
       //se puede poner print_r($res->"Lo que sea que estes buscando");
       $res=$resul->fetch_object(User::class);
       $res->password=$newp;
       $incrip = password_hash($res->password, PASSWORD_DEFAULT); //encriptado de contraseña
       $res->password=$incrip;
       $database=Database::instance(); // se conecta con la base de datos
       $storage=$database->storage(User::class); //se conecta con el almacenamiento de la base de datos
       $storage->update($res); //se guarda la nueva contraseña

       mail($correo, 
       'Cambio de contraseña', 
       "Hemos recibido su solicitud de cambio de contraseña y su nueva contraseña es: $newp");
    }
   return new Template("Changep/formcp");
 }
}