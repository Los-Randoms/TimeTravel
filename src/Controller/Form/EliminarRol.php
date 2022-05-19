<?php namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class EliminarRol extends Form {

    function __construct () {
        parent::__construct('eliminar_roles.phtml'); 
        $this->style('css\eliminarroles.css');
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Select */
        $consulta = $db->read('roles');                 // se lee la tabla de roles
        $consulta->orderBy('id');                       // ordenadorlos por Id
        $consulta->execute();                           //se ejecuta
        $this->roles = $consulta->results();            //la tabla de guarda en una variable
    }

    public function verify() {                          //parte de veficacion
        if(!isset($_POST['id']))                        //no existe
            $this->error('Selecciona un rol');          //error
        $_POST['id'] = trim($_POST['id']);              //no dejar espacios
        if(empty($_POST['id']))                         //no este vacio
            $this->error("Selecciona un rol");          //error
    }

    function _submit(): ?string {                       //parte de realización
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Delete */
        $consulta = $db->delete('roles');               //seleciona la tabla de roles
        $consulta->condition('id', $_POST['id']);       // se actualiza el nombre con tal id
        $consulta->execute();                           //termina
        return 'Se elimino el rol correctamente';   //manda el mensaje
    }
}