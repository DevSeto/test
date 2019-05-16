<?php

class Controller_login extends Controller {

	public function logout() {
		unset($_SESSION['id']);
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);
		unset($_SESSION['role']);

		header("Location: /login");
		exit();
	}

	public function index() {
		if (isset($_SESSION['id'])) {
			header("Location: /profile");
			exit();
		}

		$login_model = Controller::loadModel("login");

		if (isset($_REQUEST['login']) || isset($_REQUEST['password'])) {
			$this->validate();

			if (empty($this->error)) {
				$user = $login_model->authenticate($_REQUEST['login'], $_REQUEST['password']);
				if ($user) {
					$_SESSION['id'] = $user['id'];
					$_SESSION['first_name'] = $user['first_name'];
					$_SESSION['last_name'] = $user['last_name'];
					$_SESSION['role'] = $user['role'];

					header('Location: /profile');
					exit;
				} else {
					$this->error[] = "Login or password are incorrect";
				}
			}
		}

		$header_view = new View("header");
		$login_view = new View("login");
		$footer_view = new View("footer");

		$header['title'] = "Login";

		$data['title'] = 'Login';
		$data['name'] = isset($_REQUEST['login']) ? $_REQUEST['login'] : '';
		$data['error'] = $this->error;

		$header_view->setData($header);
		$login_view->setData($data);

		$header_view->display();
		$login_view->display();
		$footer_view->display();
	}

	private function validate() {
		if (!$_REQUEST['login'] || trim($_REQUEST['login']) == '') {
			$this->error[] = "Login is empty";
		}

		if (!$_REQUEST['password'] || trim($_REQUEST['password']) == '') {
			$this->error[] = "Pasword is empty";
		} else if (strlen($_REQUEST['password']) < 3) {
			$this->error[] = "The pasword is too short (less then 3 characters)";
		}
	}

}
