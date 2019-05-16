<?php

class Model_login extends Model {

	public function __construct() {
		$this->db = Main::getDB();
	}

	public function authenticate($_login, $_password) {
		$login = $this->db->escape(trim($_login));
		$password = $this->db->escape(trim($_password));

		$result = $this->db->query_first("SELECT * FROM users u WHERE u.`login` = '" . $login . "' AND u.`password` = '" . md5($password) . "'");

		return $result;
	}

}

;
