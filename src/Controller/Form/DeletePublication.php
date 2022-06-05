<?php

namespace Controller\Form;

use Entity\Publication;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\View;
use Modules\Router\Router;

class DeletePublication extends Form
{
    protected ?Publication $publication;
    protected ?File $file;

    function __construct()
    {
        parent::__construct('POST', [
            'id' => [
                'from' => &$_POST,
                'type' => 'integer',
            ],
        ]);
        $this->access('admin', 'editor');
    }

    function title(): string
    {
        return 'Eliminar publicacion';
    }

    function content()
    {
        return new View('page/delete_publication.phtml');
    }

    public function verify(&$data)
    {
        $this->publication = Publication::load($data['id']);
        if (empty($this->publication))
            return Message::add('La publicacion no existe');
        if (!empty($this->publication->image))
            $this->file = File::load($this->publication->image);
        return true;
    }

    function submit(&$data)
    {
        Publication::remove($this->publication->id);
        if (!empty($this->file))
            FileManager::delete($this->file);
        return Router::get('/admin/publicaciones');
    }
}
