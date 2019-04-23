<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller
{

	/**
	 * Restrict constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}


	/**
	 * Se existir sessão direciona para area restrita
	 * senão para o formulário de login
	 */
	public function index()
	{
		if ($this->session->userdata("user_id")) {
			// Carregamento de scripts
			$data = array(
				"scripts" => array(
					"util.js",
					"restrict.js"
				)
			);
			$this->template->show("restrict", $data);

		} else {
			$data = array(
				"scripts" => array(
					"util.js",
					"login.js"
				)
			);
			$this->template->show("login", $data);
		}

	}

	/**
	 * Destroi a sessão do usuário
	 */
	public function logoff()
	{
		$this->session->sess_destroy();
		header("Location: " . base_url() . "restrict");
	}

	/**
	 * Realiza o login do usuário via ajax
	 */
	public function ajax_login()
	{
		// Segurança, impede de char esse método na url
		if(! $this->input->is_ajax_request())
		{
			exit("Nenhum acesso de script direto é permitido!");
		}

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

	/**
	 * Cria um hash de uma senha
	 * @param $password
	 */
	public function criaHashPassword($password)
	{
		$password = "secret";
		echo password_hash($password, PASSWORD_DEFAULT); // $2y$10$gs.qemVIg7bFjYIG72xt5efbXyRf1XQBFFRZo4ecUxYNV.lsky7Eu
	}

	/**
	 * Consulta um usuário no sistema
	 * @param $login
	 */
	public function consultaUsuarioNoBanco($login)
	{
		$login = "andre";
		$this->load->model('users_model');
		$user = $this->users_model->get_user_data($login);
		print_r($user);
	}

}
