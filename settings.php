<?php
const DEVEL = true;
const SITE_NAME = 'Travel Time';
const UPLOAD_DIR = './public/files';

ini_set('upload_tmp_dir', __DIR__ .'/tmp/files');
ini_set('session.auto_start', 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.save_path', __DIR__ .'/tmp/sessions');
ini_set('session.name', '_SSID');

