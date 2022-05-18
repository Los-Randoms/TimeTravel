<?php namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\Page;
use Modules\Kernel\Storage;

class EditaRol extends Form {

    function __construct () {
        parent::__construct('editarol.phtml'); 
        $this->style('css\editarol.css');
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Select */
        $consulta = $db->read('roles');                  // se lee la tabla de roles
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

        if(!isset($_POST['nombre']))
            $this->error('Ingresa un nombre');
        $_POST['nombre'] = trim($_POST['nombre']);
        if(empty($_POST['nombre']))
            $this->error("Ingresa un nombre");
    }

    function _submit(): ?string {                       //parte de realización
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Update */
        $consulta = $db->update('roles');               //seleciona la tabla de roles
        $consulta->condition('id', $_POST['id']);       // se actualiza el nombre con tal id
        $consulta->set('name', $_POST['nombre']);       // se establece
        $consulta->execute();                           //termina
        return 'Se modifico el nombre correctamente';   //manda el mensaje
    }
}