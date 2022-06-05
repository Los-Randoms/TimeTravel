<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Router\Router;

class EditName extends Form
{
    protected ?User $user;

    function __construct()
    {
        parent::__construct('POST', [
            'name' => [
                'trim' => true,
                'from' => &$_POST,
            ],
            'rol' => [
                'trim' => true,
                'from' => &$_POST,
            ],
            'id' => [
                'type' => 'integer',
                'from' => &$_POST,
            ],
        ]);
        $this->access('admin');
        $this->styles[] = 'editadmin.css';
        $this->db = Storage::driver();
    }

    function content()
    {
        return Router::get("/admin/usuario/editar");
    }

    function verify(&$data)
    {
        $this->user = User::load($data['id']);
        $select = $this->db->read('roles');
        $select->condition('id', $data['rol']);
        $select->execute();
        $this->rol = $select->fetch();

        if (empty($this->user))
            return Router::get('/admin/usuarios');
        if ($this->user->id == $_SESSION['user']->id)
            return Router::get('/perfil/editar');

        return true;
    }

    function submit(&$data)
    {
        if (!empty($this->rol['name']))
            $this->user->rol =  $this->rol['name'];
        $this->user->username = $data['name'];
        $this->user->update();
        Message::add('Se ha actualizado su información');
        return Router::get('/admin/usuarios');
    }
}
