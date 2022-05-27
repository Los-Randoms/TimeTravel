<?php namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\Storage;

class CrearRoles extends Form {

    function __construct () {
        parent::__construct('crear-roles.phtml'); 
        $this->style('css/crear-roles.css');
    }

    public function verify() {                          //parte de veficacion
        if(!isset($_POST['nombre']))                    //no existe
            $this->error('Agrega un nombre');          //error
        $_POST['nombre'] = trim($_POST['nombre']);              //no dejar espacios
        if(empty($_POST['nombre']))                         //no este vacio
            $this->error("Agrega un nombre");          //error
    }

    function _submit(): ?string {                       //parte de realización
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Create */
        $consulta = $db->create('roles');               //seleciona la tabla de roles
        $consulta->set('name', $_POST['nombre']);       // se actualiza el nombre con tal id
        $consulta->execute();                           //termina
        return 'Se creo el rol correctamente';   //manda el mensaje
    }
}


