<?php

namespace Controller\Form;

use Modules\Account\User;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Router\Router;

class DeleteFile extends Form
{
    protected ?File $file;

    function __construct()
    {
        $this->access('admin');
        /** @var \Modules\Mysql\Driver */
        $driver = Storage::driver();
        $select = $driver->read(File::TABLE);
        $select->condition('id', $_GET['id']);
        $select->execute();
        $this->file = $select->fetch(File::class);
    }

    function title(): string
    {
        return 'Eliminar archivo';
    }

    function content()
    {
        return new View('page/deletefile.phtml');
    }

    public function verify(): bool
    {
        if (empty($this->file))
            return $this->error('El archivo no existe');
        return true;
    }

    function submit()
    {
        FileManager::delete($this->file);
        File::remove($this->file->id);
        Message::add('Se ha eliminado el archivo');
        return Router::get('/admin/archivos');
    }
}
