<?php namespace Modules\Kernel;

abstract class FileManager {
	static function get(string $field): ?File {
		$ref =& $_FILES[$field];
		if(empty($ref) || $ref['error'] != UPLOAD_ERR_OK)
			return null;
		$file = new File;
		$file->mime = $ref['type'];
		$file->filename = $ref['name'];
		$file->path = $ref['tmp_name'];
		$file->size = $ref['size'];
		return $file;
	}

	static function getMultiple($field): array {
		$ref =& $_FILES[$field];
		$files = [];
		if(empty($ref))
			return [];
		for($i = 0; $i < count($ref['error']); $i++) {
			if($ref['error'][$i] != UPLOAD_ERR_OK)
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

	static function all(): array {
		$files = [];
		foreach($_FILES as $k => $_file) {
			if(is_array($_file['error']))
				$files[$k] = self::getMultiple($k);
			else
				$files[$k] = self::get($k);
		}
		return $files;
	}

	static function move(File $file, string $to) {
		$old_path = $file->path;
		$new_path = UPLOAD_DIR . "/$to";
		if(!file_exists($new_path))
			mkdir($new_path, 0755, true);
		$ufilename = "$_SERVER[REQUEST_TIME_FLOAT]|{$file->filename}";
		$ufilename = md5($ufilename);
		$new_path = "$new_path/$ufilename";
		if(is_uploaded_file($file->path))
			move_uploaded_file($old_path, $new_path);
		else
			rename($old_path, $new_path);
		$file->path = "$to/$ufilename";
	}

	function delete(File $file) {
		$file_path = UPLOAD_DIR . "/{$file->path}";
		if(file_exists($file_path))
			unlink($file_path);
		File::remove($this->id);
	}
}