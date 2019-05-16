<?php

class Controller_profile extends Controller {

	public function index() {
		$user_model = Controller::loadModel("user");
		$userInfo = $user_model->getUserInfo($_SESSION['id']);

		if (isset($_REQUEST['login'])) {
			$this->validate();

			$userInfo = array(
				'login' => $_REQUEST['login'],
				'first_name' => $_REQUEST['first_name'],
				'last_name' => $_REQUEST['last_name'],
				'email' => $_REQUEST['email']);

			if (strlen($_REQUEST['pwd1']) > 0)
				$userInfo['password'] = md5($_REQUEST['pwd1']);

			if (empty($this->error)) {
				if ($user_model->editUser($_SESSION['id'], $userInfo)) {
					
				} else {
					$this->error[] = $user_model->getLastError();
				}
			}
		}

		$header_view = new View("header");
		$profile_view = new View("profile");
		$footer_view = new View("footer");

		$header['title'] = "Profile info";
		$data['action'] = "/profile";
		$data['error'] = $this->error;
		$data['login'] = $userInfo['login'];
		$data['first_name'] = $userInfo['first_name'];
		$data['last_name'] = $userInfo['last_name'];
		$data['email'] = $userInfo['email'];
		$data['submit_button'] = 'Change';
		$data['admin'] = ($_SESSION['role'] == 1) ? true : false;

		$header_view->setData($header);
		$profile_view->setData($data);

		$header_view->display();
		$profile_view->display();
		$footer_view->display();
	}

	private function validate() {
		if (!$_REQUEST['login'] || trim($_REQUEST['login']) == '') {
			$this->error[] = "Login is empty";
		}

		if (!$_REQUEST['first_name'] || trim($_REQUEST['first_name']) == '') {
			$this->error[] = "First name is empty";
		}

		if (!$_REQUEST['last_name'] || trim($_REQUEST['last_name']) == '') {
			$this->error[] = "Last name is empty";
		}

		if (!$_REQUEST['email'] || trim($_REQUEST['email']) == '') {
			$this->error[] = "Email is empty";
		} else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error[] = "Email address is invalid";
		}

		$pwd1 = trim($_REQUEST['pwd1']);
		$pwd2 = trim($_REQUEST['pwd2']);

		if ($pwd1 != '' || $pwd2 != '') {
			if ($pwd1 != $pwd2) {
				$this->error[] = "The passwords doesn't match";
			} else if (strlen($pwd1) < 3) {
				$this->error[] = "The pasword is too short (less then 3 characters)";
			}
		}
	}

}
