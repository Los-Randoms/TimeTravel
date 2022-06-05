<?php

namespace Modules\Kernel;

abstract class FileManager
{
	static function get(string $field): ?File
	{
		$ref = &$_FILES[$field];
		if (empty($ref) || $ref['error'] != UPLOAD_ERR_OK)
			return null;
		$file = new File;
		$file->mime = $ref['type'];
		$file->filename = $ref['name'];
		$file->path = $ref['tmp_name'];
		$file->size = $ref['size'];
		return $file;
	}

	static function getMultiple($field): array
	{
		$ref = &$_FILES[$field];
		$files = [];
		if (empty($ref))
			return [];
		for ($i = 0; $i < count($ref['error']); $i++) {
			if ($ref['error'][$i] != UPLOAD_ERR_OK)
				continue;
			$file = new File;
			$file->mime = $ref['type'][$i];
			$file->filename = $ref['name'][$i];
			$file->path = $ref['tmp_name'][$i];
			$file->size = $ref['size'][$i];
			$files[] = $file;
		}
		return $files;
	}

	static function all(): array
	{
		$files = [];
		foreach ($_FILES as $k => $_file) {
			if (is_array($_file['error']))
				$files[$k] = self::getMultiple($k);
			else
				$files[$k] = self::get($k);
		}
		return $files;
	}

	static function move(File $file, string $prefix)
	{
		$root = $_SERVER['DOCUMENT_ROOT'];
		$extension = pathinfo($file->filename, PATHINFO_EXTENSION);
		$new_name = uniqid("{$prefix}_", true) . ".$extension";
		$new_path = '/' . UPLOAD_DIR . "/$new_name";

		if (is_uploaded_file($file->path))
			move_uploaded_file("$root{$file->path}", "$root$new_path");
		else
			rename("$root{$file->path}", "$root$new_path");
		$file->path = $new_path;
	}

	static function delete(File $file)
	{
		$root = $_SERVER['DOCUMENT_ROOT'];
		$file_path = "$root{$file->path}";
		if (file_exists($file_path))
			unlink($file_path);
		File::remove($file->id);
	}
}
