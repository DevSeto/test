<?php

abstract class Model extends Strict {

	protected $db;
	protected $error;

	public function __construct() {
		
	}

	public function getLastError() {
		return $this->error;
	}

}

;
