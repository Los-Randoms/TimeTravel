<?php

const SECRET = '#F&55reeTh#4T2$2';
const DEVEL = true;
const SITE_NAME = 'Travel Time';
const UPLOAD_DIR = './public/files';
const TMP_DIR = __DIR__ . '/tmp';

setlocale(LC_TIME, 'es_MX');

# Development config
if(DEVEL) {
	# Upload directories config
	ini_set('upload_tmp_dir', TMP_DIR . '/files');
	# Session config
	ini_set('session.auto_start', false);
	ini_set('session.use_strict_mode', true);
	ini_set('session.save_path', TMP_DIR . '/sessions');
	ini_set('session.name', '_SSID');
	ini_set('session.lazy_write', true);
	# Session cookies config
	ini_set('session.cookie_lifetime', 0);
	ini_set('session.use_only_cookies', true);
	ini_set('session.cookie_httponly', true);
	ini_set('session.cookie_samesite', 'Lax');
	# Session garbage collection
	ini_set('session.gc_divisor', 1);
	ini_set('session.gc_probability', 2);
	ini_set('session.gc_maxlifetime', (60 * 60 * 24));
}
