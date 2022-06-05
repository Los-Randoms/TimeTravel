<?php

namespace Controller\Form;

use Modules\Router\Router;
use Entity\Publication;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Mysql\Driver;

class PublishPublication extends Form
{
    protected ?Publication $publication;
    protected Driver $db;

    function __construct()
    {
        parent::__construct('GET', [
            'id' => [
                'from' => &$_GET,
                'type' => 'integer',
            ],
        ]);
        $this->access('admin', 'editor');
        $this->db = Storage::driver();
    }

    function title(): string
    {
        return 'Publicar';
    }

    function content()
    {
        return Router::get('/admin/publicaciones');
    }

    function submit(&$data)
    {
        $this->publication->published = !$this->publication->published;
        $this->publication->update();
        Message::add('¡Se ha cambiado la publicicación!');
        return Router::get("/admin/publicaciones");
    }

    function verify(&$data)
    {
        $this->publication = Publication::load($data['id']);
        if (empty($this->publication)) {
            Message::add('No existe la publicacion');
            return Router::get('/admin/publicaciones');
        }
        return true;
    }
}
