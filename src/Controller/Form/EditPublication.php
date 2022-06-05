<?php

namespace Controller\Form;

use Modules\Router\Router;
use Entity\Publication;
use Modules\Kernel\File;
use Modules\Kernel\FileManager;
use Modules\Kernel\Form;
use Modules\Kernel\Message;
use Modules\Kernel\Storage;
use Modules\Kernel\View;
use Modules\Mysql\Driver;

class EditPublication extends Form
{
    protected ?Publication $publication;
    protected Driver $db;
    protected ?File $file;
    protected array $accepts = [
        'image/png',
        'image/jpeg',
        'image/gif',
    ];

    function __construct()
    {
        parent::__construct('POST', [
            'id' => [
                'from' => &$_POST,
                'type' => 'integer',
            ],
            'title' => [
                'from' => &$_POST,
                'trim' => true,
            ],
            'body' => [
                'from' => &$_POST,
                'length' => 20,
            ],
            'published' => [
                'from' => &$_POST,
                'type' => 'boolean',
            ],
            'image' => [
                'from' => &$_FILES,
                'optional' => true,
            ],
        ]);
        $this->access('admin', 'editor');
        $this->db = Storage::driver();
    }

    function title(): string
    {
        return 'Editar publicacion';
    }

    function content()
    {
        $this->publication = Publication::load($_GET['id']);
        if (empty($this->publication)) {
            Message::add('La publicacion no existe');
            return Router::get('/admin/publications');
        }
        return new View('page/edit_publication.phtml', [
            'publication' => $this->publication,
        ]);
    }

    function submit(&$data)
    {
        if (!empty($this->file)) {
            if (isset($this->publication->image)) {
                $old_file = File::load($this->publication->image);
                FileManager::delete($old_file);
            }
            FileManager::move($this->file, 'publ');
            $this->file->save();
        }
        $this->publication->title = $data['title'];
        $this->publication->body = $data['body'];
        $this->publication->published = $data['published'];
        if (!empty($this->file))
            $this->publication->image = $this->file->id;
        $this->publication->autor = $_SESSION['user']->id;
        $this->publication->update();
        Message::add('¡Publicacion modificada!');
        return Router::get("/admin/publicaciones");
    }

    function verify(&$data)
    {
        $this->publication = Publication::load($data['id']);
        if (empty($this->publication))
            return Message::add('No existe la publicacion');
        $this->file = FileManager::get('image');
        if (!empty($this->file)) {
            if (!in_array($this->file->mime, $this->accepts))
                return Message::add('La imagen no esta en un formato aceptado');
        }
        return true;
    }
}
