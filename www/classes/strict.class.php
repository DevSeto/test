<?php

abstract class Strict {

	private function errinfo() {
		return " " . __FILE__ . " at line: " . __LINE__;
	}

	public function __isset($name) {
		throw new Exception("Can't use isset() for not existing variable: '$name'.");
	}

	public function __unset($name) {
		throw new Exception("Can't unset variable: '$name' because it does not exists.");
	}

	public function __set($name, $value) {
		throw new Exception("Can't edit variable: '$name' because it doesn't exists.");
	}

	public function __get($name) {
		throw new Exception("Can't use variable: '$name' because it doesn't exists.");
	}

	public function __call($method, $params) {
		throw new Exception("Called method: '$method' doesn't exists.");
	}

}
