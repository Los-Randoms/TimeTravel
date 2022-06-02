<?php

namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;

class EditRol extends Form
{

    function __construct()
    {
        $this->access('admin');
        $this->styles[] = 'editrol.css';
    }

    function title(): string {
        return 'Editar rol';
    }

    function content() {
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Select */
        $consulta = $db->read('roles');
        $consulta->orderBy('id');
        $consulta->execute();
        return new View('page/edit_rol.phtml', [
            'roles' => $consulta->results(),
        ]);
    }

    public function verify(): bool
    {
        if (!isset($_POST['id']))
            return $this->error('Selecciona un rol');
        $_POST['id'] = trim($_POST['id']);
        if (empty($_POST['id']))
            return $this->error("Selecciona un rol");
        if (!isset($_POST['nombre']))
            return $this->error('Ingresa un nombre');
        $_POST['nombre'] = trim($_POST['nombre']);
        if (empty($_POST['nombre']))
            return $this->error("Ingresa un nombre");
    }

    function submit()
    {
        $db = Storage::driver();
        /** @var \Modules\Mysql\Query\Update */
        $consulta = $db->update('roles');
        $consulta->condition('id', $_POST['id']);
        $consulta->set('name', $_POST['nombre']);
        $consulta->execute();
        Message::add('Se modifico el nombre correctamente');
    }
}

