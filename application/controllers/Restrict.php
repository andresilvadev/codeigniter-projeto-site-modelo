<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
	}


	public function index()
	{
//		echo password_hash("secret", PASSWORD_DEFAULT);
//		$2y$10$gs.qemVIg7bFjYIG72xt5efbXyRf1XQBFFRZo4ecUxYNV.lsky7Eu

//		$this->load->model('users_model');
//		$user = $this->users_model->get_user_data("andre");
//		print_r($user);

		$data = array(
			"scripts" => array(
				"util.js",
				"login.js"
			)
		);

		$this->template->show("login", $data);
	}

	public function ajax_login()
	{
		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if (empty($username)) {
			$json["status"] = 0;
			$json["error_list"]["#username"] = "Usuário não pode ser vazio!";
		} else {
			$this->load->model('users_model');
			$result = $this->users_model->get_user_data($username);

			if($result) {
				$user_id = $result->id;
				$user_password = $result->password;

				if(password_verify($password, $user_password)) {
					$this->session->set_userdata("user_id", $user_id);
				} else {
					$json["status"] = 0;
				}
			} else {
				$json["status"] = 0;
			}
			if ($json["status"] == 0) {
				$json["error_list"]["#btn_login"] = "Usuário  e/ou senha incorreta!";
			}
		}

		echo json_encode($json);

	}


}
