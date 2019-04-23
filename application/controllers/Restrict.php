<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller
{

	public function index()
	{
		// echo password_hash("secret", PASSWORD_DEFAULT);
		// $2y$10$gs.qemVIg7bFjYIG72xt5efbXyRf1XQBFFRZo4ecUxYNV.lsky7Eu

		$this->template->show("login");
	}
}
