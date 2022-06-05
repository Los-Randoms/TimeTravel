<?php

namespace Controller\Form;

use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Router;

class DeleteFile extends Form
{
    function __construct()
    {
        parent::__construct('POST', [
            'id' => [
                'from' => &$_POST,
                'type' => 'integer'
            ],
        ]);
        $this->access('admin');
    }

    function title(): string
    {
        return 'Eliminar archivo';
    }

    function content()
    {
        return new View('page/deletefile.phtml');
    }

    public function verify(&$data)
    {
        $this->file = File::load($data['id']);
        if (empty($this->file))
            return Message::add('El archivo no existe');
        return true;
    }

    function submit(&$data)
    {
        FileManager::delete($this->file);
        Message::add('Se ha eliminado el archivo');
        return Router::get('/admin/archivos');
    }
}
