<?php
	class Session {

		private $logged_in = false;
		public $username;


		function __construct() {
			if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
			if($this->check_login()) {
				//
			} else {
				//
			}
		}

		public function is_logged_in() {
			return $this->logged_in;
		}

		
		
		public function login($username) {
			//
			if ($id) {
				$this->username = $_SESSION['username'] = $username;
				$_SESSION['wrong'] = ""; //for test only
				$this->logged_in = true;
			}
			
			$id = md5(rand(0,999999999999999));
			return $id;
		}
		
		
		

		public function logout() {
			unset($_SESSION['username']);
			unset($this->username);
			$this->logged_in = false;
		}

		private function check_login() {
			if (isset($_SESSION['username'])) {
				$this->username = $_SESSION['username'];
				$this->logged_in = true;
			} else {
				unset($this->username);
				$this->logged_in = false;
			}
		}

	}

$session = new Session(); 

?>