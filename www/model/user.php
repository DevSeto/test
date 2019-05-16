<?php

class Model_user extends Model {

	private $filter;

	public function __construct() {
		$this->db = Main::getDB();
		$this->filter = false;
	}

	public function setFilter($filter_field, $filter_text) {
		$this->filter = array();

		if (!$filter_field || !$filter_text) {
			$this->filter = false;
		} else {
			$this->filter['field'] = $this->db->escape($filter_field);
			$this->filter['text'] = $this->db->escape($filter_text);
		}
	}

	public function getFilter() {
		return $this->filter;
	}

	public function getUserInfo($_user_id) {
		$user_id = (int) $_user_id;

		$result = $this->db->query_first("SELECT * FROM users WHERE id='" . $user_id . "'");

		return $result;
	}

	public function addNewUser($user_params) {

		if (!$this->unique_val("login", $user_params['login'])) {
			$this->error = "The login does not unique";
			return false;
		}

		if (!$this->unique_val("email", $user_params['email'])) {
			$this->error = "The email does not unique";
			return false;
		}

		$this->db->query_insert("users", $user_params);

		return true;
	}

	public function editUser($id, $user_params) {

		if (!$this->unique_val("login", $user_params['login'], $id)) {
			$this->error = "The login is not unique";
			return false;
		}

		if (!$this->unique_val("email", $user_params['email'], $id)) {
			$this->error = "The email is not unique";
			return false;
		}

		$this->db->query_update("users", $user_params, "`id`=" . (int) $id);

		return true;
	}

	public function deleteUser($id) {
		$result = $this->db->query('DELETE FROM users WHERE id="' . (int) $id . '"');

		return $result;
	}

	public function selectFilteredUsers($limit = 10, $offset = 0) {
		$limit = (int) $limit;
		$offset = (int) $offset;

		if ($limit <= 0) {
			$limit = 10;
		}

		$where_clause = '';

		if ($this->filter) {
			$where_clause = ' WHERE ' . $this->filter['field'] . ' LIKE "%' . $this->filter['text'] . '%"';
		}

		//We place LIMIT here, not in the paginator, because in the test project description it was sais to make paginator as independent as possible
		$result = $this->db->fetch_all_array('
				SELECT * FROM users ' . $where_clause .
				' LIMIT ' . $limit . ' OFFSET ' . $offset);

		return $result;
	}

	public function countUsers() {
		$where_clause = '';

		if ($this->filter) {
			$where_clause = ' WHERE ' . $this->filter['field'] . ' LIKE "%' . $this->filter['text'] . '%"';
		}

		$result = $this->db->query_first("SELECT count(*) as users_count FROM users" . $where_clause);

		return $result['users_count'];
	}

	/* --- PRIVATE METHODS --- */

	private function unique_val($field, $value, $id = false) {

		$id = (int) $id;
		$and_id_clause = '';

		if ($id) {
			$and_id_clause = " AND id<>'" . $id . "'";
		}

		$result = $this->db->query_first('SELECT * FROM users WHERE ' . $field . '="' . $this->db->escape($value) . '"' . $and_id_clause);

		return ($result) ? false : true;
	}

}

;
