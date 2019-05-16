<?php

class Main extends Strict {

	private static $db;

	public static function setDB($_db) {
		self::$db = $_db;
	}

	public static function getDB() {
		return self::$db;
	}

}
