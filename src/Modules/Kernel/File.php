<?php namespace Modules\Kernel;

class File extends Entity {
	const TABLE = 'files';
	public string $filename;
	public string $mime;
	public int $size;
	public string $path;

	function url(): string {
		return '/' . UPLOAD_DIR . "/{$this->path}";
	}
}
