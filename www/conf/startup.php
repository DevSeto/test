<?php

//magic quotes fix
if (get_magic_quotes_gpc()) {

	function fix_magicQuotes(&$value, $key) {
		$value = stripslashes($value);
	}

	$gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	array_walk_recursive($gpc, 'fix_magicQuotes');
}

require_once "conf/config.php";

$doc_root = $_SERVER['DOCUMENT_ROOT'] . '/';
$dir_sep = !empty($_SERVER['COMSPEC']) ? ';' : ':';

$path = '';

if (!empty($conf['include_dir'])) {
	foreach ($conf['include_dir'] as $include_dir) {
		$path .= $doc_root . $include_dir . $dir_sep;
	}
} else {
	$path = $doc_root;
}

ini_set('include_path', $path);

spl_autoload_register(function ($class_name) {
	$filename = "classes/" . strtolower($class_name) . ".class.php";

	if (!file_exists($filename)) {
		throw new Exception("Can't find class: " . $class_name);
	}

	include_once $filename;
});
