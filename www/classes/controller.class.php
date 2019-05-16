<?php

abstract class Controller extends Strict {

	protected $error = array();

	public abstract function index();

	private static function load($path, $name, $prefix) {
		require_once $path . $name . ".php";

		$full_class_name = $prefix . $name;
		$class = new $full_class_name;

		return $class;
	}

	public static function loadModel($model_name) {
		return self::load("model/", $model_name, "Model_");
	}

	public static function loadView($view_name) {
		return self::load("view/", $view_name, "View_");
	}

}

;
