<?php 

	
	class User {


		private $db = null,
				$data = array(),
				$session_name,
				$logged_in = false;

		public function __construct($user = null) {

			$this->db = db::get_instance();
			$this->session_name = config::get('session/session_name');
			$this->cookie_name = config::get('cookie/cookie_name');


			if(!$user) {

				if(session::exist($this->session_name)) {

					$user = session::get($this->session_name);

					if($this->find($user)) {

						$this->logged_in = true;
					}
				}
			} else {

				$this->find($user);
			}

		}

		public function logged_in() {

			return $this->logged_in;
		}
		public function find($user = null) {

			$field = (is_numeric($user)) ? 'id' : 'username';

			$data = $this->db->get('users', array($field, '=', $user));

			if($data->count()) {
				$this->data = $data->first();

				return true;
			}

			return false;

		}



		public function create($fields) {

			$user = $this->find(input::get('username'));

			if(!$user) {

				$this->db->insert('users', $fields);
				return true;
			}

			return false;

		}

		public function login($username, $password, $remember = false) {

			$user = $this->find($username);

			if($user) {



				if($this->data()->password === $password) {

						session::put($this->session_name, $this->data()->id);

						if($remember) {


								echo "user asked to be remembere";
							

							$hash_check = $this->db->get('user_session', array('user_id', '=', $this->data()->id));

							if(!$hash_check->count()) {

								$hash = hash::unique();

								$this->db->insert('user_session', array(

									'user_id' => $this->data()->id,
									'hash' => $hash
							));


							} else {

								$hash = $hash_check->first()->hash;


							}


							cookie::put($this->cookie_name, $hash, config::get('cookie/cookie_expiry'));
						}
						return true;
				}
			}

			return false;
		}


		public function logout() {

			$this->db->delete('user_session', 'user_id', $this->data()->id);
			session::delete($this->session_name);
			cookie::delete($this->cookie_name);

		}


		public function data() {

			return $this->data;
		}
	}