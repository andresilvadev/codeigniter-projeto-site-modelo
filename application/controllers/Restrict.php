<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller
{

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


}
