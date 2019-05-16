<?php

error_reporting(E_ALL | E_STRICT);

session_start();
try {
	require_once "conf/startup.php";
	require_once "lib/clsMySQL.php";

	$db = new clsMySQL($conf['db_host'], $conf['db_login'], $conf['db_pwd'], $conf['db_name']);
	$db->connect();
	Main::setDB($db);

	$router = new Router();
	$router->setControllersPath("controller");
	$route = isset($_GET['route']) ? $_GET['route'] : '';
	if (isset($_SESSION['id']) || $route == 'login' || $route == 'register') {
		$router->loadController($route);
	} else {
		headers_sent() || header('Location: /login');
		exit;
	}
} catch (Exception $e) {
	include "lib/error.php";
	showException($e);
}