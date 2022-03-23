<?php namespace Core;

function autoload(string $class) {
	$namespace = strtok($class, '\\');
	if($namespace != 'Core')
		return false;
	$path = str_replace('\\', '/', $class);
	$path = strchr($path, '/');
	require "$_SERVER[SITE_DIR]/core". "$path.php";
}

function src_load(string $class) {
	$namespace = strtok($class, '\\');
	if($namespace != $_ENV['site']['name'])
		return false;
	$path = str_replace('\\', '/', $class);
	$path = strchr($path, '/');
	require "$_SERVER[SITE_DIR]/src". "$path.php";
}

spl_autoload_register('\Core\autoload');
spl_autoload_register('\Core\src_load');
