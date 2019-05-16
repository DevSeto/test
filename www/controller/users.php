<?php

class Controller_users extends Controller {

	public $userModel = null;
	function __construct() {
		$this->userModel = Controller::loadModel("user");
		if ($_SESSION['role'] != 1) {
			header("Location: /profile");
			exit();
		}
	}

	public function search() {
		$page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
		$limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 10;
		$search_field = isset($_REQUEST['field']) ? $_REQUEST['field'] : '';
		$search_text = isset($_REQUEST['text']) ? $_REQUEST['text'] : '';
		$this->userModel->setFilter($search_field, $search_text);
		$pagin = new Paginator($this->userModel->countUsers(), $limit);
		$pagin->selectPage($page);
		$users = $this->userModel->selectFilteredUsers($limit, $pagin->getOffset());

		$data['error'] = $this->error;
		$data['users'] = $users;
		$data['delete'] = 'users/delete?id=';
		$data['pagin'] = $pagin->getData();
		$data['pages'] = $pagin->getPages();
		$data['search_field'] = $search_field;
		$data['search_text'] = $search_text;

		$users_table_view = new View("users_table");

		$users_table_view->setData($data);

		$users_table_view->display();
	}

	public function delete() {
		$data['result_text'] = "Fail to delete user.";

		if (isset($_REQUEST["id"])) {
			if ($_REQUEST["id"] == $_SESSION['id']) {
				$data['result_text'] = 'Can\'t to delete himself';
				$result_view = new View("fail");
			} else {
				if ($this->userModel->deleteUser($_REQUEST["id"])) {
					$result_view = new View("success");
					$data['result_text'] = "User was succesfully deleted.";
				} else {
					$result_view = new View("fail");
				}
			}
		} else {
			$result_view = new View("fail");
			$data['result_text'] = "Can't delete this user.";
		}

		$header_view = new View("header");
		$footer_view = new View("footer");

		$header['title'] = "Profile info";
		$data['link_url'] = "/users";
		$data['link_text'] = "View users";

		$header_view->setData($header);
		$result_view->setData($data);

		$header_view->display();
		$result_view->display();
		$footer_view->display();
	}

	public function importUsers() {
		$fh = fopen($_FILES['file']['tmp_name'], 'r+');
		$existUsers = 0;
		$newUsers = 0;
		$count = 0;
		while( ($row = fgetcsv($fh)) !== FALSE ) {
			$user = [];
			if($count && !empty($row[2]) && !empty($row[3]) && !empty($row[4])){
				$user['first_name'] = $row[0];
				$user['last_name'] = $row[1];
				$user['login'] = $row[2];
				$user['email'] =  $row[3];;
				$user['password'] = $row[4];
				if($this->userModel->addNewUser($user)){
					$newUsers++;
				}else{
					$existUsers++;
				}
			}
			$count++;
		}
		$csvImportMessages = new View("csvImportMessages");

		$csvImportMessages->setData(['newUsers'=>$newUsers,'existUsers'=>$existUsers]);

		$csvImportMessages->display();

	}
	public function index() {

		if (isset($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}

		$header['title'] = "Profile info";
		$users['title'] = "View users";

		$header_view = new View("header");
		$users_view = new View("users");
		$footer_view = new View("footer");

		$header_view->setData($header);
		$users_view->setData($users);

		$header_view->display();
		$users_view->display();
		$this->search();
		$footer_view->display();
	}

}
